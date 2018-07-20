---
layout: article
title: "DDA-Chapter 7 Transactions Weak Isolation Levels"
category: blog
tag:
- DDA 
- english

#excerpt:
toc: flase
image:
#  feature:
    teaser: /blog/2018.07/transaction-29-638.jpg
#  thumb:
date:   2018-07-20 08:33
---

# Read Committed
## two guarantees:
- 1. When reading from the database, you will only see data that has been committed (no dirty reads).
- 2. When writing to the database, you will only overwrite data that has been committed (no dirty writes).
![dirty reads](https://i.pinimg.com/originals/4a/ba/7f/4aba7fb375c8b8ef80e2fd1c04abafeb.png)
![dirty write](https://i.pinimg.com/originals/c7/dc/6c/c7dc6c21c2f6c65654554f4ca5b8a348.png)
## Implementing read committed
- Most commonly, databases prevent dirty writes by using row-level locks
- How do we prevent dirty reads?
One option would be to use the same lock, and to require any transaction that wants to read an object to briefly acquire the lock and then release it again immediately after reading.                       **However,** the approach of requiring read locks does not work well in practice, because one long-running write transaction can force many read-only transactions to wait until the long-running transaction has completed.
for every object that is written, the database remembers both the old committed value and the new value set by the transaction that currently holds the write lock.
# Snapshot Isolation and Repeatable Read
## read committed isolation couldn't prevent **Read skew <no repeat read>**
![Figure 7-6. Read skew: Alice observes the database in an inconsistent state.](https://i.pinimg.com/originals/f3/81/93/f38193d519d72de20df2b56ab7871c55.png)
- This anomaly is called a **nonrepeatable read or read skew**
- Some issue (cannot tolerate such temporary inconsistency)
Backups
Analytic queries and integrity checks
## Snapshot isolation is the most common **solution to this problem**. The idea is that each transaction reads from a consistent snapshot of the database
## @pro @mvcc Implementing snapshot isolation
- **multiversion concurrency control (MVCC)**
- MVCC DIFF read committed isolation
If a database only needed to provide read committed isolation, but not snapshot isolation, it would be sufficient to keep two versions of an object: the committed version and the overwritten-but-not-yet-committed version. However, storage engines that support snapshot isolation typically use MVCC for their read committed isolation level as well. A typical approach is that read committed uses a separate snapshot for each query, while snapshot isolation uses the same snapshot for an entire transaction
- @pro ![Figure 7-7. Implementing snapshot isolation using multi-version objects.](https://i.pinimg.com/originals/d5/df/83/d5df8380d703f38dff000fc5ca42002b.png)
- @pro Visibility rules for observing a consistent snapshot
1. At the start of each transaction, the database makes a list of all the other transactions that are in progress (not yet committed or aborted) at that time. Any writes that those transactions have made are ignored, even if the transactions subsequently commit.
2. Any writes made by aborted transactions are ignored.
3. Any writes made by transactions with a later transaction ID (i.e., which started after the current transaction started) are ignored, regardless of whether those transactions have committed.
4. All other writes are visible to the application’s queries.
- Put another way, an object is visible if both of the following conditions are true:
1. At the time when the reader’s transaction started, the transaction that created the object had already committed.
2. The object is not marked for deletion, or if it is, the transaction that requested deletion had not yet committed at the time when the reader’s transaction started.
## Indexes and snapshot isolation
- common index / garbage collection / append-only/copy-on-write variant /B-trees
## Repeatable read and naming confusion
- **Snapshot isolation** is a useful isolation level, especially for read-only transactions. However, many databases that implement it call it by different names. In **Oracle** it is called **serializable**, and in **PostgreSQL** **and** **MySQL** it is called **repeatable read** [23].
# Preventing Lost Updates
![Figure 7-1. A race condition between two clients concurrently incrementing a counter.](https://i.pinimg.com/originals/14/2d/94/142d943e2b6b9dbcbadc39a72a4bbd68.png)
## different scenarios
- Incrementing a counter or updating an account balance (requires reading the current value, calculating the new value, and writing back the updated value)
- Making a local change to a complex value, e.g., adding an element to a list within a JSON document (requires parsing the document, making the change, and writing back the modified document)
- Two users editing a wiki page at the same time, where each user saves their changes by sending the entire page contents to the server, overwriting whatever is currently in the database
## Atomic write operations
```
UPDATE counters SET value = value + 1 WHERE key = 'foo';
```

- Atomic operations are usually implemented by taking an **exclusive lock** on the object
## Explicit locking

```

BEGIN TRANSACTION;
SELECT * FROM figures
WHERE name = 'robot' AND game_id = 222 FOR UPDATE;
-- Check whether move is valid, then update the position
-- of the piece that was returned by the previous SELECT. UPDATE figures SET position = 'c4' WHERE id = 1234;
COMMIT;
```

>  tip : The FOR UPDATE clause indicates that the database should take a lock on all rows returned by this query.
## Automatically detecting lost updates
- An advantage of this approach is that databases can perform this check efficiently in conjunction with snapshot isolation. However, **MySQL/ InnoDB’s repeatable read does not detect lost updates**
## Compare-and-set
```
-- This may or may not be safe, depending on the database implementation 
UPDATE wiki_pages SET content = 'new content' WHERE id = 1234 AND content = 'old content';
```

## Conflict resolution and replication
# Write Skew and Phantoms
![Figure 7-8. Example of write skew causing an application bug.](https://i.pinimg.com/originals/c7/dc/6c/c7dc6c21c2f6c65654554f4ca5b8a348.png)
## Characterizing write skew
- It is neither a dirty write nor a lost update,
- You can think of **write skew as a generalization of the lost update problem.** Write skew can occur if two transactions read the same objects, and then update some of those objects (different transactions may update different objects). In the special case where different transactions update the same object, you get a dirty write or lost update anomaly (depending on the timing).
```

BEGIN TRANSACTION;
SELECT * FROM doctors
WHERE on_call = true AND shift_id = 1234 FOR UPDATE;
UPDATE doctors
SET on_call = false WHERE name = 'Alice' AND shift_id = 1234;
COMMIT;
```

>  As before, FOR UPDATE tells the database to lock all rows returned by this query.
## More examples of write skew
- Meeting room booking system
Example 7-2. A meeting room booking system tries to avoid double-booking (not safe under snapshot isolation)
```

BEGIN TRANSACTION; -- Check for any existing bookings that overlap with the period of noon-1pm SELECT COUNT(*) FROM bookings
WHERE room_id = 123 AND end_time > '2015-01-01 12:00' AND start_time < '2015-01-01 13:00';
-- If the previous query returned zero:
INSERT INTO bookings (room_id, start_time, end_time, user_id) VALUES (123, '2015-01-01 12:00', '2015-01-01 13:00', 666);
COMMIT;
```

>  Unfortunately, **snapshot isolation** does not prevent another user from concurrently inserting a conflicting meeting. In order to guarantee you won’t get scheduling conflicts, you once again need **serializable isolation**.
- Multiplayer game
In Example 7-1, we used a lock to prevent lost updates (that is, making sure that two players can’t move the same figure at the same time). However, the lock doesn’t prevent players from moving two different figures to the same position on the board or potentially making some other move that violates the rules of the game. Depending on the kind of rule you are enforcing, you might be able to use a unique constraint, but otherwise you’re vulnerable to write skew.
- Claiming a username
Fortunately, a unique constraint is a simple solution here
- Preventing double-spending
## Phantoms causing write skew
- All of these examples follow a similar pattern:
1. A SELECT query checks whether some requirement is satisfied by searching for rows that match some search condition (there are at least two doctors on call, there are no existing bookings for that room at that time, the position on the board doesn’t already have another figure on it, the username isn’t already taken, there is still money in the account).
2. Depending on the result of the first query, the application code decides how to continue (perhaps to go ahead with the operation, or perhaps to report an error to the user and abort).
3. If the application decides to go ahead, it makes a write (INSERT, UPDATE, or DELETE) to the database and commits the transaction.
- The steps may occur in a different order. For example, you could first make the write, then the SELECT query, and finally decide whether to abort or commit based on the result of the query.
- In the case of the doctor on call example, the row being modified in step 3 was one of the rows returned in step 1, so we could make the transaction safe and avoid write skew by locking the rows in step 1 (SELECT FOR UPDATE). However, the other four examples are different: they check for the absence of rows matching some search condition, and the write adds a row matching the same condition. If the query in step 1 doesn’t return any rows, SELECT FOR UPDATE can’t attach locks to anything.
- This effect, where a write in one transaction changes the result of a search query in another transaction, is called a **phantom** [3]. **Snapshot isolation avoids phantoms in read-only queries, but in read-write transactions like the examples we discussed, phantoms can lead to particularly tricky cases of write skew.**
## Materializing conflicts
- If the problem of phantoms is that there is no object to which we can attach the locks, perhaps we can artificially introduce a lock object into the database?
>  For example, in the meeting room booking case you could imagine creating a table of time slots and rooms. Each row in this table corresponds to a particular room for a particular time period (say, 15 minutes). You create rows for all possible combinations of rooms and time periods ahead of time, e.g. for the next six months.
>  Now a transaction that wants to create a booking can lock (SELECT FOR UPDATE) the rows in the table that correspond to the desired room and time period. After it has acquired the locks, it can check for overlapping bookings and insert a new booking as before. Note that the additional table isn’t used to store information about the booking—it’s purely a collection of locks which is used to prevent bookings on the same room and time range from being modified concurrently.
- This approach is called **materializing conflicts**, because it takes a phantom and turns it into a lock conflict on a concrete set of rows that exist in the database [11]. Unfortunately, it can be hard and error-prone to figure out how to materialize conflicts, and it’s ugly to let a concurrency control mechanism leak into the application data model. For those reasons, materializing conflicts should be considered a last resort if no alternative is possible. **A serializable isolation level is much preferable in most cases.**
# **OK, what I saw** 
## 1. read committed / dirty read / dirty write
## 2. repeatable read (read skew) / snapshot isolation (repeatable read in mysql) implement by MVCC 
## 3. lost update : scenarios and method ( atomic write oprations / explicit locking / automatically detecting lost updates / compare-and-set)
## 4. write skew / examples ( meeting room booking system / multiplayer game / claiming a username / preventing double-spending) / phantoms causing write skew ( pattern ) / sovle method : materializing conflicts , serializable isolation level 
