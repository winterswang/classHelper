2014/10/17 12:25 AM
成功修复了地理位置搜索功能。
实现语音识别搜索功能。
修改文件为WeixinController.php, weixinMsg.php.

2014/10/16
之前建立了菜单（在微信文档里操作）。
菜单前两个已实现其功能。但发现第二个菜单的功能无必要性。
地理位置搜索功能失效。
另注：图文消息个数，限制为10条以内。

2014/10/10
修改了代码结构。其中包括WeixinController.php, weixinEvent.php, weixinLoc.php（原weixinLocEvent.php）。

2014/10/08
修改菜单。

2014/09/25
于weixinLocEvent.php中增加了关于查找附近课程的部分代码（为实现整体功能）。

2014/09/23
于WeixinController.php中增加了关于查询若不合法，返回提示语句的部分。
各个接口目前都可稳定存储内容或输出信息。

2014/09/21
成功验证了用于插入定位事件的子类weixinLocEvent。
于表course中插入字段description，并插入相关信息，此字段内容包含课程的具体信息和用户可能输入的模糊查询。
于发送图文消息的方法responseNews()中加入循环，使得该方法可输出多图文消息。

2014/09/20
通过模糊查询利用图文消息发送课程信息。
于weixinMsg.php中添加了方法search()用于模糊查询。于WeixinController.php中添加了方法responseNews()用于发送图文消息。

2014/09/16
获取用户信息部分已成功。
另外将LOCATION事件存储，于weixinEvent.php中添加了方法insertLocation用于存储LOCATION。

2014/09/14
修改了WeixinController.php，于消息类型为text与image处分别增加了获取用户信息和生成带参数的二维码的相关代码，但是暂时未成功。

2014/09/10
修改了WeixinController.php的格式。
在目录下增加了util的文件夹，存放WxApiTools.php，此文件用来调用几乎所有的API。

2014/09/07
将所有代码更新（包括index）。
并在models里创建weixinMsg.php，此处用来处理微信推送过来的各类消息。

2014/09/05
更新了controller中WeixinController类的代码，接受微信推过来的XML，解析出消息类型，并将消息的各个参数存储至DB中。
接下来将把消息存储至DB中的过程封装成类weixinMsg。

2014/09/05
结合zy的代码，完成了事件和消息的双向监听，暂时微信可以自动回复消息，DB存储还有一些问题有待完善

2014/09/02
调通了整个流程，接受微信推过来的XML，解析出各种事件，完成路由，存储到DB，接下来就是继续抽象和封装，特别是DB和事件那部分。

2014/09/01
更新了Model中，weixinEvent类的代码，提供了一个测试插入DB的脚本和方法。

2014/08/31
在models创建了一个微信事件的类，负责处理微信发过来的事件消息。目前是负责完成数据库的插入操作



目录介绍
weixin 这是查找课程的微信项目，回来可以扩展，所以暂时是微信的项目
weixin/tools：这个文件夹是用来存放工具类的。方便我们做代码的抽象。一些公共的方法，可以提出来，放在tools里，完成一些固定的操作。
weixin/models:这是用来存放数据库操作的目录，面向对象的编程思路应该是数据库对应的对象 进行封装增删改查
weixin/scripts：这里放一些测试的脚本，检测一下你的function是否正确，或者一些其他的检测脚本目的
weixin/docs:关于微信项目的文档，包括DB设计，接口设计等。
classHelper
===========

find class 
