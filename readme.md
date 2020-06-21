# Project 2 说明文档 
姓名：  陆勇雍  
学号：  19302010034
## 项目完成情况
### 首页
登录逻辑：完成。通过session完成，如果当前存在`$_SESSiON['uname']`即为登录，退出即`unset`。    

刷新逻辑：完成。点击'刷新'，向url拼接字符串`?refresh=1`，如果`$_GET['refresh']==1`,即刷新，在数据库中随机选择六张图片。    

图片逻辑：完成。在`travelimage`数据表中增加一个`'favorNum'`字段，表示收藏数，展示时即选择收藏数最大的前六张图片。   
### 浏览页  
筛选逻辑：完成。  通过`$_GET[]`获得筛选字段，模糊查询主要以`LIKE`完成，多字段查询以`OR`连接完成

图片逻辑：完成。能根据搜索信息的不同显示相对应的图片以及页码的正确显示。
### 搜索页  
搜索逻辑：完成。  同浏览页。  

图片逻辑：完成。  同浏览页。  
### 登陆页面
登录逻辑：完成。通过js与php检测信息是否规范，并在数据库中查询有无相匹配的记录，其中密码通过哈希加盐完成， 如果有，即为登陆成功，反之，则提示错误并返回登录页面。
### 注册页面
注册逻辑：完成。首先通过js，php判断提交信息合法性，如果合法则通过`$_POST`存入数据库,注册成功，否则提示错误并返回注册页面。
### 我的照片
图片逻辑：完成。显示当前账户下的图片。  

删除逻辑：完成。在数据库中删除相对应图片并在当前网页中显示。  
### 我的收藏
展示逻辑：完成。同‘我的照片’图片逻辑。  

删除逻辑：完成。即取消收藏，在`traveluser`中增加一个字段`‘favor’`，记录收藏的图片名，取消收藏即将该图片名去除。 
### 上传页面
合法性校验：完成。  

修改逻辑：完成。判断是否存在`$_GET['modify']`,确定为普通的上传界面和显示图片相关信息的修改界面。  

### 详细图片页面
信息展示：完成。通过php从数据库中提取相对应信息，并展示。  

收藏功能：完成。在当前用户的`favor`字段中加入该图片的名字即为收藏，去除该名称为取消收藏，同时在`travelimage`中的`favorNum`字段相应+1或-1。

## Bonus完成情况  
1.完成在数据库中存储用户名密码时，使用哈希加盐。注册时先将密码MD5加密，再随机生成一串字符串，这个就是盐，将盐拼接到md5加密后的字符串形成新的字符串，再将该字符串md5加密得到最后的密码，连同盐一起存入数据库。登陆时，即将输入的密码md5加密，匹配相应的盐，再md5加密，看得到的字符串是否与存储的字符串相同，如果是则登陆成功。  
2.完成在服务器上部署project，并用域名itravel33.site，端口88.这里需要注意，截至6月21号，阿里云初审完成，已提交管局，管局审核尚未完成，咨询后获知该步骤需要十五至二十天。但本人在pc端与手机上测试既可以通过ip地址加端口号访问，`39.97.226.32:88`,也可以通过域名加端口号访问，`itravel33.site:88`。  
3.使用jQuery的心得：jQuery给我整体的感觉是很灵活，很便捷。实现同一个功能，js需要的代码量往往远多于jQuery所需的代码量。jQuery选择元素的方法很灵活，简洁。可以很方便的的修改css样式，实现动画很简单。比如首页的“回到顶部”按钮就是通过jQuery完成，jQuery的链式结构以及获取元素的属性也很方便，如上传界面，展示上传界面的图片，先获得上传文件路径，再把img标签的src属性设置为相对应路径，jQuery很方便的实现了这个功能。

## 对PJ 2和本门课程的建议
感谢老师与助教们对pj2和本门课程的辛勤付出，我通过老师对这门课程的讲解对web网页的各个内容有了一定的了解，并通过lab，pj锻炼的自己的实际编程能力，在这个过程中更是加深了相关内容的理解与灵活运用。我也从学期初对web一无所知的小白进步成了现在能简陋的完成一个网站，小骄傲的同时也深知进步空间还很大很大，还要继续努力。  
对于pj2，自我感觉很全面地考察了对相关语言编写代码的运用，有效地提高了学生地编程水平，建议是bonus或许也可以做出相应的提示，因为我作为一个学生的角度是很想也很愿意花时间完成bonus的，也可以说是强迫症把bonus当成了必须完成的任务，从一开始的看不懂到通过相关资料的查询到完成了bonus是一件很有成就感的事。  
对于本门课程的建议，老师讲解的十分用心，很全面很细致，让我受益良多。建议是或许可以讲解一些代码题目，一方面加深学生的理解，另一方面也达到备考的效果。  
最后再次感谢老师和助教们的辛苦付出！