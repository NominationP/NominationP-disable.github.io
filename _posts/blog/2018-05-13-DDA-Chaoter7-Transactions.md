---
layout: article
title: "DDA_Chapter7 Transactions Summary"
category: blog
tag:
- DDA 
- english

#excerpt:
toc: flase
image:
#  feature:
    teaser: /blog/2018.05/v2-d7fdf141526cf835fb3db39cc9c9d1ff_1200x500.jpg
#  thumb:
date:   2018-05-13 11:28
---

# DDA_Chapter7 Transactions Summary


## various examples of race conditions:

### Dirty reads < read committed >

One client reads another client’s writes before they have been committed. The read committed isolation level and stronger levels prevent dirty reads.

Transactions running at the read committed isolation level must prevent dirty reads. This means that any writes by a transaction only become visible to others when that transaction commits (and then all of its writes become visible at once).

### Dirty writes < read committed >

One client overwrites data that another client has written, but not yet committed. Almost all transaction implementations prevent dirty writes.

However, what happens if the earlier write is part of a transaction that has not yet committed, so the later write overwrites an uncommitted value? This is called a dirty write [28]. Transactions running at the read committed isolation level must prevent dirty writes, usually by delaying the second write until the first write’s transaction has committed or aborted.

### Read skew (nonrepeatable reads) < Snapshot Isolation and Repeatable Read >

- Alice observes the database in an inconsistent state. (transfers $100 from one of her accounts to the other.)
- Backups (cannot tolerate such temporary inconsistency)
- Analytic queries and integrity checks (cannot tolerate such temporary inconsistency)

A client sees different parts of the database at different points in time. This issue is most commonly prevented with snapshot isolation, which allows a transaction to read from a consistent snapshot at one point in time. It is usually implemented with multi-version concurrency control (MVCC).

### Lost updates

Two clients concurrently perform a read-modify-write cycle. One overwrites the other’s write without incorporating its changes, so data is lost. Some implementations of snapshot isolation prevent this anomaly automatically, while others require a manual lock (SELECT FOR UPDATE).

### Write skew < serializable isolation >

A transaction reads something, makes a decision based on the value it saw, and writes the decision to the database. However, by the time the write is made, the premise of the decision is no longer true. Only serializable isolation prevents this anomaly.

### Phantom reads

A transaction reads objects that match some search condition. Another client makes a write that affects the results of that search. Snapshot isolation prevents straightforward phantom reads, but phantoms in the context of write skew require special treatment, such as index-range locks.













