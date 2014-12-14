app.factory('pw', function ($q, $http) {
    // Service logic
    console.debug("MODULO","cargado desde pw");
    
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