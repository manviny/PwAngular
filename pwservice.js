          
    /**
    * trust HTML will output html as it is
    * <div ng-bind-html="htmlString | unsafe "></div>
    * @return HTML
    */
    app.filter('unsafe', function($sce) { return function(val) { return $sce.trustAsHtml(val); }; });

    /**
    * Splits a string into an array given the sepatator ( | , ' ' ) and returns the desired index
    * [imagen1.jpg|imagen2.jpg|imagen3.jpg]
    * @return {{lit.images | split:'|':1}} -> imagen2.jpg
    */
    app.filter('split', function() { return function(input, splitChar, splitIndex) { return input.split(splitChar)[splitIndex]; }; });  
    app.filter('trustSrc', function() { return function(src) { return $sce.trustAsResourceUrl(src); }; });  


    
    app.factory('PW', function ($q, $http, $location) {
        // Service logic
        console.debug("cargado desde footer","cuando terminado pasa a .module");

        //url actual
        var url = $location.absUrl().replace($location.protocol() + '://' + $location.host(),'');


        /**
         * page()       -> returns page by getting actual url
         * page(1044)   -> returns page by id
         * @type {pageId}
         * return   number of children
         */
         var page = function(pageId){

            if(!pageId) pageId = url;       
            
            var deferred = $q.defer();
            $http.post('/web-service/', { action: 'getPage', pageId: pageId }) 
            .success(function(data){
                deferred.resolve(data);
            })  
            return deferred.promise;
         }

        /**
         * numChildren(1014)
         * numChildren()
         * @type {pageId}
         * return   number of children
         */
         var numChildren = function(pageId){
            if(!pageId) pageId = url;   

            var deferred = $q.defer();
            $http.post('/web-service/', { action: 'numChildren', pageId: pageId }) 
            .success(function(data){
                deferred.resolve(data);
            })  
            return deferred.promise;
         }

        /**
         * pagination(1014, startPage, numItems, sortMethod)
         * id         ->  parent page
         * startPage  ->  number of page to start with, 
         * numItems   ->  number of children to return
         * sortMethod ->  type of sort ['-blog_fecha'...]
         * @type {[type]}
         */
         var children = function(id, start, numItems, sort){
            var deferred = $q.defer();

            start = (start - 1) * numItems;

            $http.post('/web-service/', {
                action: 'find', 
                selector: 'parent='+ id + ',' + 'start='+ start + ',' + 'limit='+ numItems + ',' + 'sort='+ sort 
            })  
            .success(function(data){
                deferred.resolve(data);
            })      
            return deferred.promise;
         }     

         return {

            numChildren: numChildren,
            children: children,
            page: page

         };        


    });

