app.factory('pw', function ($q, $http) {
    // Service logic
    console.debug("MODULO","cargado desde pw1");

    /**
     * numChildren(1014)
     * @type {pageId}
     * return   number of children
     */
    var numChildren = function(pageId){
      var deferred = $q.defer();
      $http.post('web-service/', { action: 'numChildren', pageId: pageId }) 
    .success(function(data){
      deferred.resolve(data);
    })  
     return deferred.promise;
    }

    /**
     * pagination(1014, startPage, itemsXpage, sortMethod)
     * id       ->  parent page
     * startPage  ->  number of page to start with, 
     * itemsXpage ->  number of children to return
     * sortMethod ->  type of sort ['-blog_fecha'...]
     * @type {[type]}
     */
    var pagination = function(id, start, itemsXpage, sort){
      var deferred = $q.defer();

      start = (start - 1) * itemsXpage;

      $http.post('web-service/', {
          action: 'find', 
          selector: 'parent='+ id + ',' + 'start='+ start + ',' + 'limit='+ itemsXpage + ',' + 'sort='+ sort 
      })  
      .success(function(data){
        deferred.resolve(data);
      })      
     return deferred.promise;
    }     

    return {

    numChildren: numChildren,
    pagination: pagination

    };        


  });

  
  /**
   * trust HTML will output html as it is
   * <div ng-bind-html="htmlString | unsafe "></div>
   * @return HTML
   */
  app.filter('unsafe', function($sce) {
      return function(val) {
          return $sce.trustAsHtml(val);
      };
  });


  /**
   * Splits a string into an array given the sepatator ( | , ' ' ) and returns the desired index
   * [imagen1.jpg|imagen2.jpg|imagen3.jpg]
   * @return {{lit.images | split:'|':1}} -> imagen2.jpg
   */
    app.filter('split', function() {
        return function(input, splitChar, splitIndex) {
            return input.split(splitChar)[splitIndex];
        };
    });


