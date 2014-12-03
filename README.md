PwAngular
=========

##Methods

$page->getPage()  
$page->getPage(1015)  
 
$page->getChildren()  
$page->getChildren(2024)  
$page->getChildren('template=products')  

$page->createPage()

##How to use $page->createPage()
Saves a page under the processwire tree given the parent id, template name, title and JSON with inputfields and data
```javascript
	app.controller('myCtrl', function ($scope) {
	  	// $page->createPage( pageID,'template','title', '{"fieldName":"value"}')
	  	<?=$page->createPage(1077,'mytemplate','The Title', '{"body":"text in body"}')?>;
	});
```
