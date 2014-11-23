CI扩展
===========
最近在阅读CI的源码，然后发现CI的一些函数有一些常用的功能还不是太全，于是试着自己写了一些扩展，`这些扩展都是在不改变原生函数的正常使用下进行修改的，就算添加了，也不会影响原生函数的使用。`所以可以直接替换CI system内的内容

-------------------
扩展内容
------------------------
- ####directory_helper.php

|函数|扩展功能 | 
| :--------: |:--------:| 
|directory_map_by_array| 支持数组遍历文件的功能 | 

- ####date_helper.php

|函数|扩展功能 | 
| :--------: |:--------:| 
|timespan| 支持返回时差的最大单位 | 
