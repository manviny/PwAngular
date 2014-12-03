PwAngular
=========

##Methods

$page->getPage()
$page->getPage(1015)
 
$page->getChildren()
$page->getChildren(2024)
$page->getChildren('template=products')

$page->createPage

##How to use it $page->createPage()
```javascript
	app.controller('myCtrl', function ($scope) {
	  	// Save page $page->createPage( pageID,'template','title', '{"fieldName":"value"}')
	  	<?=$page->createPage(1077,'mytemplate','The Title', '{"body":"text in body"}')?>;
	});
```
