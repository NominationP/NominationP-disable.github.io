# Annotation Summary of Martin Kleppmann-Designing Data-Intensive Applications_ The Big Ideas Behind Reliable, Scalable, and Maintainable Systems-O’Reilly Media (2017).pdf.
#### Chapter 5. Replication
 *Highlight [151]:* single-leader

 *Highlight [151]:* multi-leader

 *Highlight [151]:* leaderless

#### Leaders and Followers
 *Highlight [152]:* fundamental constraints
 *and Note [152]:* 基本的限制

 *Highlight [152]:* eventual consistency

 *Highlight [152]:* monotonic reads guarantees

 *Highlight [152]:* read-your-writes

 *Highlight [152]:* leader-based replication (also known as active/passive or master–slave replication)

#### Synchronous Versus Asynchronous Replication
 *Highlight [154]:* substantial delay
 *and Note [154]:* 真实的延迟

 *Highlight [154]:* outage
 *and Note [154]:* 运行中断

#### Setting Up New Followers
 *Highlight [155]:* semi-synchronous

 *Highlight [155]:* chain replication

 *Highlight [155]:* flux
 *and Note [155]:* 不断变动

#### Handling Node Outages
 *Highlight [156]:* log sequence number

 *Highlight [156]:* binlog coordinates

 *Highlight [156]:* caught up

 *Highlight [156]:* arcane
 *and Note [156]:* 神秘的

 *Highlight [157]:* trickier
 *and Note [157]:* 棘手的

 *Highlight [157]:* failover

 *Highlight [157]:* Determining that the leader has failed

 *Highlight [157]:* foolproof
 *and Note [157]:* 万无一失的,不会出错的

 *Highlight [157]:* Choosing a new leader

 *Highlight [157]:* controller node

 *Highlight [157]:* Reconfiguring the system to use the new leader

 *Highlight [157]:* fraught
 *and Note [157]:* 忧虑的

#### Implementation of Replication Logs
 *Highlight [158]:* disclosed
 *and Note [158]:* 透漏,显露

 *Highlight [158]:* split brain

 *Highlight [158]:* spike
 *and Note [158]:* 弃用,尖物

 *Highlight [158]:* work under the hood
 *and Note [158]:* 在底层工作

 *Highlight [158]:* Statement-based replication

 *Highlight [159]:* reasonable
 *and Note [159]:* 明智的

 *Highlight [159]:* Statements that have side effects
 *and Note [159]:* 有副作用的语句

 *Highlight [159]:* Write-ahead log (WAL) shipping

 *Highlight [160]:* Logical (row-based) log replication

 *Highlight [160]:* logical log,

 *Highlight [160]:* A transaction that modifies several rows generates several such log records, followed by a record indicating that the transaction was committed. MySQL’s binlog (when configured to use row-based replication) uses this approach [17].
 *and Note [160]:* 一个修改多行的事务会生成多个这样的日志记录，然后是一条记录，指出该事务已提交。 MySQL的二进制日志（当配置为使用基于行的复制时）使用这种方法[17]。

#### Problems with Replication Lag
 *Highlight [161]:* change data capture

 *Highlight [161]:* Trigger-based replication

 *Highlight [161]:* The replication approaches described so far are implemented by the database system,
 *and Note [161]:* The replication approaches described so far are implemented by the database system,

 *Highlight [161]:* then you may need to move replication up to the application layer.
 *and Note [161]:* 那么您可能需要将复制移动到应用程序层。

 *Highlight [161]:* triggers

 *Highlight [161]:* stored procedures.

 *Highlight [161]:* Trigger-based replication typically has greater overheads than other replication methods, and is more prone to bugs and limitations than the database’s built-in replication. However, it can nevertheless be useful due to its flexibility.
 *and Note [161]:* 基于触发器的复制通常比其他复制方法具有更高的开销，并且比数据库的内置复制更容易出现错误和限制。 但是，由于其灵活性，它仍然有用。

 *Highlight [161]:* Being able to tolerate node failures is just one reason for wanting replication. As
 *and Note [161]:* 能够容忍节点故障只是需要复制的一个原因。 如

 *Highlight [161]:* read-scaling

#### Reading Your Own Writes
 *Highlight [162]:* eventual consistency

 *Highlight [162]:* The term “eventually” is deliberately vague: in general, there is no limit to how far a replica can fall behind.
 *and Note [162]:* “最终”一词故意含糊不清：总的来说，复制品落后的程度没有限制。

 *Highlight [162]:* replication lag

 *Highlight [163]:* read-your-writes consistency

 *Highlight [163]:* read-after-write consistency,

 *Highlight [163]:* It makes no promises about other users:
 *and Note [163]:* 它对其他用户没有任何承诺：

 *Highlight [163]:* reassures
 *and Note [163]:* 使安心

#### Monotonic Reads
 *Highlight [164]:* logical timestamp

 *Highlight [164]:* This metadata will need to be centralized.
 *and Note [164]:* 这个元数据需要集中。

 *Highlight [164]:* Monotonic Reads

 *Highlight [164]:* anomaly
 *and Note [164]:* 反常

 *Highlight [164]:* moving backward in time

#### Consistent Prefix Reads
 *Highlight [165]:* monotonic reads.
 *and Note [165]:* 单调阅读

 *Highlight [165]:* Our third example of replication lag anomalies concerns violation of causality
 *and Note [165]:* 我们的第三个复制例子滞后于反常因果关系

 *Highlight [166]:* There is a causal dependency between those two sentences: Mrs. Cake heard Mr.
 *and Note [166]:* 这两句话之间存在因果依赖关系

 *Highlight [166]:* consistent prefix reads

#### Solutions for Replication Lag
 *Highlight [167]:* Pretending that replication is synchronous when in fact it is asynchronous is a recipe for problems down the line.
 *and Note [167]:* 假设事实上它是异步的，复制是同步的，这是解决问题的方法。

#### Use Cases for Multi-Leader Replication
 *Highlight [168]:* multi-leader

 *Highlight [169]:* Let’s compare how the single-leader and multi-leader configurations fare in a multidatacenter deployment:
 *and Note [169]:* 我们来比较多数据中心部署中单引导者和多引导者配置的方式：

 *Highlight [170]:* As multi-leader replication is a somewhat retrofitted feature in many databases, there
 *and Note [170]:* 由于多领导者复制在很多数据库中都有所改进，

 *Highlight [170]:* are often subtle configuration pitfalls and surprising interactions with other database features. For example,
 *and Note [170]:* 往往是微妙的配置陷阱和令人惊讶的与其他数据库功能的交互。 例如，

 *Highlight [170]:* integrity constraints
 *and Note [170]:* 完整性约束

 *Highlight [170]:* regardless of whether your device currently has an internet connection.
 *and Note [170]:* 无论您的设备目前是否具有互联网连接。

 *Highlight [170]:* From an architectural point of view, this setup is essentially the same as multi-leader replication between datacenters, taken to the extreme: each device is a “datacenter,” and the network connection between them is extremely unreliable. As the rich history of broken calendar sync implementations demonstrates, multi-leader replication is a tricky thing to get right.
 *and Note [170]:* 从架构的角度来看，这种设置基本上与数据中心之间的多领导者复制相同，极端：每个设备都是“数据中心”，它们之间的网络连接极其不可靠。 正如破碎的日历同步实现的丰富历史所证明的，多领导者复制是一件棘手的事情。

 *Highlight [170]:* Collaborative editing
 *and Note [170]:* Collaborative editing

 *Highlight [170]:* Collaborative editing
 *and Note [170]:* 协作编辑

 *Highlight [170]:* Real-time collaborative editing

#### Handling Write Conflicts
 *Highlight [173]:* convergent

 *Highlight [173]:* last write wins

 *Highlight [173]:* and let writes that originated at a highernumbered replica always take precedence over writes that originated at a lowernumbered replica.
 *and Note [173]:* 并且让源自较高编号副本的写入始终优先于源自较低编号副本的写入。

 *Highlight [173]:* perhaps by prompting the user).
 *and Note [173]:* 也许通过提示用户）。

 *Highlight [173]:* each write is still considered separately for the purposes of conflict resolution.
 *and Note [173]:* 为了解决冲突的目的，每个写入仍被分开考虑。

 *Highlight [174]:* Conflict resolution rules can quickly become complicated, and custom code can be error-prone. Amazon is a frequently cited example of surprising effects due to a conflict resolution handler: for some time, the conflict resolution logic on the shopping cart would preserve items added to the cart, but not items removed from the cart. Thus, customers would sometimes see items reappearing in their carts even though they had previously been removed
 *and Note [174]:* 冲突解决规则可能很快变得复杂，并且自定义代码可能容易出错。 亚马逊是一个经常引用的冲突解决处理程序令人惊讶的效果的例子：一段时间以来，购物车上的冲突解决逻辑将保留添加到购物车的物品，但不保存从购物车中移除的物品。 因此，顾客有时会看到物品重新出现在他们的购物车中，即使他们之前已被移除

 *Highlight [174]:* Conflict-free replicated datatypes (CRDTs)

 *Highlight [174]:* Mergeable persistent data structures

 *Highlight [174]:* Operational transformation

#### Multi-Leader Replication Topologies
 *Highlight [175]:* Multi-Leader Replication Topologies
 *and Note [175]:* 多领导复制拓扑

 *Highlight [175]:* replication topology

 *Highlight [175]:* propagated
 *and Note [175]:* 传播,繁殖

 *Highlight [175]:* plausible topology
 *and Note [175]:* 似是而非的拓扑结构

 *Highlight [175]:* vice versa
 *and Note [175]:* 反之亦然

 *Highlight [175]:* all-to-all

 *Highlight [175]:* circular topology

 *Highlight [175]:* star

 *Highlight [175]:* nodes need to forward data changes they receive from other nodes.
 *and Note [175]:* 节点需要转发他们从其他节点收到的数据更改。

#### Writing to the Database When a Node Is Down
 *Highlight [177]:* version vectors

 *Highlight [177]:* dominance
 *and Note [177]:* 控制

 *Highlight [177]:* in-house Dynamo system

 *Highlight [177]:* Dynamo-style

 *Highlight [177]:* unlike a leader database, that coordinator does not enforce a particular ordering of writes. As we shall see, this difference in design has profound consequences for the way the database is used.
 *and Note [177]:* 与领导者数据库不同，协调员不强制执行特定的写入顺序。 我们将会看到，这种设计差异对数据库的使用方式有着深远的影响。

 *Highlight [178]:* read requests are also sent to several nodes

 *Highlight [178]:* Read repair and anti-entropy
 *and Note [178]:* 阅读修复和反熵

 *Highlight [179]:* Read repair

 *Highlight [179]:* Anti-entropy process

 *Highlight [179]:* anti-entropy process

 *Highlight [179]:* quorum

 *Highlight [180]:* There may be more than n nodes in the cluster, but any given value is stored only on n nodes. This allows the dataset to be partitioned,
 *and Note [180]:* 群集中可能有多于n个节点，但是任何给定值仅存储在n个节点上。 这允许对数据集进行分区，

#### Limitations of Quorum Consistency
 *Highlight [181]:* This is the case because the set of nodes to which you’ve written and the set of nodes from which you’ve read must overlap.
 *and Note [181]:* 情况就是这样，因为你写的节点集合和你读过的节点集合必须重叠。

 *Highlight [181]:* but possible scenarios include:
 *and Note [181]:* 但可能的情况包括：

 *Highlight [181]:* the w writes may end up on different nodes than the r reads
 *and Note [181]:* w写入可能会结束在不同于r读取的节点上

 *Highlight [182]:* and overall succeeded on fewer than w replicas,
 *and Note [182]:* 并且总体成功率低于W副本，

 *Highlight [182]:* If a node carrying a new value fails, and its data is restored from a replica carrying an old value, the number of replicas storing the new value may fall below w, breaking the quorum condition.
 *and Note [182]:* 如果携带新值的节点失败，并且其数据从携带旧值的副本恢复，则存储新值的副本数可能会低于w，从而打破法定条件。

 *Highlight [182]:* but it’s wise to not take them as absolute guarantees.
 *and Note [182]:* 但不要把它们作为绝对的保证是明智的。

 *Highlight [182]:* so the previously mentioned anomalies can occur in applications. Stronger guarantees generally require transactions or consensus.
 *and Note [182]:* 所以前面提到的异常可能发生在应用程序中。 更强有力的担保通常需要交易或共识。

 *Highlight [182]:* the database typically exposes metrics for the replication lag
 *and Note [182]:* 数据库通常会公开复制滞后的度量标准，

 *Highlight [182]:* By subtracting a follower’s current position from the leader’s current position, you can measure the amount of replication lag.
 *and Note [182]:* 通过从领导者的当前位置减去跟随者的当前位置，您可以测量复制滞后量。

#### Sloppy Quorums and Hinted Handoff
 *Highlight [183]:* latter
 *and Note [183]:* 后者

 *Highlight [183]:* sloppy quorum

#### Detecting Concurrent Writes
 *Highlight [184]:* hinted handoff.

 *Highlight [184]:* It’s only an assurance of durability, namely that the data is stored on w nodes somewhere.
 *and Note [184]:* 这只是保证耐用性，即数据存储在某处的w节点上。

 *Highlight [186]:* Then, as long as we have some way of unambiguously determining which write is more “recent,” and every write is eventually copied to every replica, the replicas will eventually converge to the same value.
 *and Note [186]:* 然后，只要我们有明确的方式确定哪个写入更“近期”，并且每个写入最终都会复制到每个副本，则副本最终会收敛到相同的值。

 *Highlight [186]:* we can force an arbitrary order on them
 *and Note [186]:* 我们可以强制他们的任意命令

 *Highlight [186]:* last write wins

 *Highlight [186]:* There are some situations, such as caching, in which lost writes are perhaps acceptable.
 *and Note [186]:* 有些情况下，如缓存，其中丢失的写入也许是可以接受的。

 *Highlight [186]:* The only safe way of using a database with LWW is to ensure that a key is only written once and thereafter treated as immutable, thus avoiding any concurrent updates to the same key.
 *and Note [186]:* 与LWW一起使用数据库的唯一安全方法是确保密钥只写入一次，然后将其视为不可变，从而避免对同一密钥进行任何并发更新。

 *Highlight [186]:* causally dependent

 *Highlight [187]:* Whether one operation happens before another operation is the key to defining what concurrency means.
 *and Note [187]:* 在另一个操作之前是否发生一个操作是定义并发意味着什么的关键。

 *Highlight [187]:* concurrent

 *Highlight [187]:* whether they literally overlap in time.
 *and Note [187]:* 无论它们是否在时间上重叠。

 *Highlight [187]:* regardless of the physical time at which they occurred.
 *and Note [187]:* 不管他们发生的实际时间如何。

 *Highlight [187]:* between this principle and the special theory of relativity in physics
 *and Note [187]:* 这个原理与物理学中的狭义相对论之间

 *Highlight [187]:* Consequently, two events that occur some distance apart cannot possibly affect each other if the time between the events is shorter than the time it takes light to travel the distance between them.
 *and Note [187]:* 因此，如果事件之间的时间短于光通过它们之间的距离所需的时间，那么发生一定距离的两个事件不可能相互影响。

 *Highlight [187]:* In computer systems, two operations might be concurrent even though the speed of light would in principle have allowed one operation to affect the other
 *and Note [187]:* 在计算机系统中，即使光速原则上允许一个操作影响另一个操作，但两个操作可能是并发的

 *Highlight [188]:* oblivious
 *and Note [188]:* 未察觉

 *Highlight [189]:* happened before

 *Highlight [189]:* knew about or depended on

 *Highlight [189]:* In this example, the clients are never fully up to date with the data on the server, since there is always another operation going on concurrently.
 *and Note [189]:* 在这个例子中，客户端永远不会完全掌握服务器上的数据，因为总会有另一个操作同时进行。

 *Highlight [189]:* Note that the server can determine whether two operations are concurrent by looking at the version numbers—it does not need to interpret the value itself (so the value could be any data structure). The algorithm works as follows:
 *and Note [189]:* 请注意，服务器可以通过查看版本号来确定两个操作是否并发 - 它不需要解释该值本身（因此该值可以是任何数据结构）。 该算法的工作原理如下：

 *Highlight [190]:* When a write includes the version number from a prior read, that tells us which previous state the write is based on. If you make a write without including a version number, it is concurrent with all other writes, so it will not overwrite anything—it will just be returned as one of the values on subsequent reads.
 *and Note [190]:* 当写入包含之前读取的版本号时，它会告诉我们写入的是以前的哪个状态。 如果在不包含版本号的情况下进行写操作，则它与所有其他写操作并发，因此它不会覆盖任何内容 - 它将仅作为后续读取中的一个值返回。

 *Highlight [190]:* siblings

 *Highlight [190]:* However, if you want to allow people to also remove things from their carts, and not just add things, then taking the union of siblings may not yield the right result:
 *and Note [190]:* 但是，如果您想让人们也可以从购物车中取出东西，而不是仅仅添加东西，那么将兄弟姐妹结合起来可能不会产生正确的结果：

 *Highlight [191]:* instead, the system must leave a marker with an appropriate version number to indicate that the item has been removed when merging siblings.
 *and Note [191]:* 相反，系统必须留下具有适当版本号的标记，以指示在合并兄弟时该项目已被移除。

 *Highlight [191]:* tombstone

 *Highlight [191]:* error-prone
 *and Note [191]:* 容易出错

 *Highlight [191]:* per replica

 *Highlight [191]:* version vector

 *Highlight [191]:* dotted version vector

 *Highlight [191]:* causal context.

#### Summary
 *Highlight [193]:* Users should see the data in a state that makes causal sense: for example, seeing a question and its reply in the correct order.
 *and Note [193]:* 用户应该将数据视为具有因果意义的状态：例如，按照正确的顺序查看问题及其答复。

