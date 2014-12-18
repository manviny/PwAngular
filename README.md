PwAngular
=========

Module config
=============
**Enter scripts**  
<script src="https://code.angularjs.org/1.3.2/angular-sanitize.min.js"></script>
<script src="/site/templates/app/bower_components/angular-translate/angular-translate.min.js"></script>



PHP Methods that return json data
=================================


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


Javascript (angularjs) calls that get  json data
================================================
Get page by ID
```javascript
$http.post('http://ip/web-service/', {action: 'getPage', pageId: 1046 })
.success(function(data) {
    console.debug("success",data);
})
```
Get children by parent id
```javascript
$http.post('http://ip/web-service/', {action: 'getChildren', pageId: 1062 })
.success(function(data) {
    console.debug("children",data);
})
```
Find pages by selector
```javascript
$http.post('http://ip/web-service/', {action: 'find', selector: 'template=directivo,parent=1077' })
.success(function(data) {
    console.debug("children",data);
})
```
Get number of children of a given page
```javascript
$http.post('http://ip/web-service/', { action: 'numChildren', pageId: 1014 })
.success(function(data) {
    console.debug("number of children",data);
})
```
Useful angularjs
================

####N number of words
```javascript
	string.split(' ', 8).join(' ')
```

####first paragraph
```javascript
	string.split('.', 1).join('.').concat('...')
```
####Default value when empty
```javascript
	{{ lit.title || 'not available' }}
```
####Conditional class
```javascript
	ng-class="{active: $index==0}"
```






