PwAngular
=========

#Methods

##How to use $page->getPage()
Saves a page under the processwire tree given the parent id, template name, title and JSON with inputfields and data
```javascript
	app.controller('myCtrl', function ($scope) {
	  	$scope.blog = [];		
	  	$scope.blog = <?=$page->getPage()?>;							// get data of actual page
	  	$scope.blog = <?=$page->getPage(1045)?>;						// get data of page that matches the id
	});
```
 
##How to use $page->getChildren()
Saves a page under the processwire tree given the parent id, template name, title and JSON with inputfields and data
```javascript
	app.controller('myCtrl', function ($scope) {
	  	$scope.children = [];			
	  	$scope.children = <?=$page->getChildren()?>;					// get children and its data of the actual page
	  	$scope.children = <?=$page->getChildren(1077)?>;				// will get the children of the page with the indicated ID
	  	$scope.children = <?=$page->getChildren('template=products')?>;	// children of the page that matches the selector
	});
```

##How to use $page->createPage()
Saves a page under the processwire tree given the parent id, template name, title and JSON with inputfields and data
```javascript
	app.controller('myCtrl', function ($scope) {
	  	// $page->createPage( pageID,'template','title', '{"fieldName":"value"}')
	  	<?=$page->createPage(1077,'mytemplate','The Title', '{"body":"text in body"}')?>;
	});
```

Useful angularjs
================

####N number of words
```javascript
	string.split(' ', 8).join(' ')
```
####Default value when empty
```javascript
	{{ lit.title || 'not available' }}
```
####Conditional class
```javascript
	ng-class="{active: $index==0}"
```






