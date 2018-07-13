---
layout: article
title: "2PC"
category: blog
tag:
- DDA 
- english

#excerpt:
toc: flase
image:
#  feature:
    teaser: /blog/2018.07/116770-20160313203429600-179395429.png
#  thumb:
date:   2018-07-13 15:00
---

## meaning
    2PC : 2 Phase Commit 
    Totally Different with 2PC [2 Phase Lock]
    blocking atomic commit protocol

## Background
    Atomic Commit for single-node db, but not suitable for distributed
    #pro read committed isolation
    A transaction commit must be irrevocable—you are not allowed to change your mind and retroactively abort a transaction after it has been committed. The reason for this rule is that once data has been committed, it becomes visible to other transactions, and thus other clients may start relying on that data; this principle forms the basis of read committed isolation

## ![2PC](https://i.pinimg.com/originals/7b/84/2e/7b842ea606d0b80a5638675e873a28f6.png)


> marriage analogy: 

>before saying “I do,” you and your bride/groom have the freedom to abort the transaction by saying “No way!” (or something to that effect). However, after saying “I do,” you cannot retract that statement. If you faint after saying “I do” and you don’t hear the minister speak the words “You are now husband and wife,” that doesn’t change the fact that the transaction was committed. When you recover consciousness later, you can find out whether you are married or not by querying the minister for the status of your global transaction ID, or you can wait for the minister’s next retry of the commit request (since the retries will have continued throughout your period of unconsciousness).



    1. When the application wants to begin a distributed transaction, it requests a transaction ID from the coordinator. This transaction ID is globally unique.
    2. The application begins a single-node transaction on each of the participants, and attaches the globally unique transaction ID to the single-node transaction. All reads and writes are done in one of these single-node transactions. If anything goes wrong at this stage (for example, a node crashes or a request times out), the coordinator or any of the participants can abort.
    3. When the application is ready to commit, the coordinator sends a prepare request to all participants, tagged with the global transaction ID. If any of these requests fails or times out, the coordinator sends an abort request for that transaction ID to all participants.
    4. When a participant receives the prepare request, it makes sure that it can definitely commit the transaction under all circumstances. This includes writing all transaction data to disk (a crash, a power failure, or running out of disk space is not an acceptable excuse for refusing to commit later), and checking for any conflicts or constraint violations. By replying “yes” to the coordinator, the node promises to commit the transaction without error if requested. In other words, the participant surrenders the right to abort the transaction, but without actually committing it.
    5. When the coordinator has received responses to all prepare requests, it makes a definitive decision on whether to commit or abort the transaction (committing only if all participants voted “yes”). The coordinator must write that decision to its transaction log on disk so that it knows which way it decided in case it subsequently crashes. This is called the commit point.
    6. Once the coordinator’s decision has been written to disk, the commit or abort request is sent to all participants. If this request fails or times out, the coordinator must retry forever until it succeeds. There is no more going back: if the decision was to commit, that decision must be enforced, no matter how many retries it takes. If a participant has crashed in the meantime, the transaction will be committed when it recovers—since the participant voted “yes,” it cannot refuse to commit when it recovers.

## Defects
    Coordinator failure
        need to wait coordinator recover
    blocking atomic commit protocol
## Solved
    three-phase commit (3PC)
        with unbounded network delay and process pauses (see Chapter 8), it cannot guarantee atomicity.
    In general, nonblocking atomic commit requires a perfect failure detector
        In a network with unbounded delay a timeout is not a reliable failure detector
    ** For this reason, 2PC continues to be used, despite the known problem with coordinator failure. **












