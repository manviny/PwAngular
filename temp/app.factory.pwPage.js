app.factory('pwPage', function ($http, $q, $filter, $upload, $rootScope) {

/**
 *      - createPage(parent, template, title) 
 *
 *      - removeFromField(pageId, fieldName, content) 
 *
 *      - upgradePage(pageId, data)
 *
 *      - getPage(pageId)
 *
 *      - saveToJson(pageId)
 *
 *      - getChildren(pageId, selector, fields) 
 *
 *      - togglePublished(pageId, state)
 *
 *      - uploadFile($files, PageID, InputFieldType, removeAll)
 *
  *     - createJson(PageID, title, selector, fields)                          Creates json file under assets folder
  *
  *     - createMunicipioP24
 */


    var result = { 


        /**
         * Creates a new PW page
         * @param  {[type]} parent   id of the parent
         * @param  {[type]} template name of the template
         * @param  {[type]} title    title for the page
         * @return {[type]}          [description]
         */
        createPage: function (parent, template, title) {
            var promise = $http({url: '/web-service/create-page/', method: "POST", data: { parent: parent , template: template, title: title}} )
                .then(  
                    function(response) { return response.config.data }, 
                    function(response) { console.debug("no se ha podido guardar, intentar de nuevo")} 
                );
            return promise;    
        },

        /**
         * Empty content from field, if is an array, remove only the element with the name content, ex: image, picture.jpg
         * 
         *     2 calls
         *     function (pageId, fieldName, '') -> deletes field
         *     function (pageId, fieldName, content) -> deletes element froma array
         *     
         * removes only picture.jpg from field image
         * @param  {[type]} pageId    id of the page that contains the field
         * @param  {[type]} fieldName single or array field
         * @param  {[type]} content   if empty deletes all field content, if not search in array to delete only that part
         * @return {[type]}           [description]
         */
        removeFromField: function (pageId, fieldName, content) {
            var promise = $http({url: '/web-service/remove-from-field/', method: "POST", data: { pageId: pageId , fieldName: fieldName, content: content}} )
                .then(  
                    function(response) { return response.config.data }, 
                    function(response) { console.debug("no se ha podido guardar, intentar de nuevo")} 
                );
            return promise;    
        },


        /**
         * Updates Data Page
         * @param  {[type]} pageId Id of the page where data will be stored
         * @param  {[type]} data   Data send to serve in JSON format { inputFieldType: 'value', inputFieldType: 'value', ...}
         * @return {[type]}        
         */
        upgradePage: function (pageId, data) {
            var promise = $http({url: '/web-service/upgrade-page/', method: "POST", data: { pageId: pageId , data: data}} )
                .then(  
                    function(response) { return response.config.data }, 
                    function(response) { console.debug("no se ha podido guardar, intentar de nuevo")} 
                );
            return promise;    
        },

        /**
         * Gets Data from desired page in server
         * @param  {[type]} pageId Id of the page we want
         * @return {[type]}        data encoded in json format
         */
        getPage: function (pageId) {

            var deferred = $q.defer();

            $http({url: '/web-service/get-page/', method: "POST", data: { pageId: pageId }} )
                .success(function(response){
                    deferred.resolve(response);
            });

            return deferred.promise;    
        },

        /**
         * Gets Data from desired page in server
         * @param  {[type]} pageId Id of the page we want
         * @return {[type]}        data encoded in json format
         */
        saveToJson: function (pageId) {

            var deferred = $q.defer();

            $http({url: '/web-service/save-to-json/', method: "POST", data: { pageId: pageId }} )
                .success(function(response){
                    deferred.resolve(response);
            });

            return deferred.promise;    
        },
        /**
         * Gets Children form page
         * @param  {[type]} pageId   parent o where to start from
         * @param  {[type]} selector pw selector, ex: "template=mytemplate, has_parent=1534"
         * @param  {[type]} fields   pw InputFields we want back, if empty we get all, ex: ['lat','lng','zoom']
         * @return {[type]}          [description]
         */
        getChildren: function (pageId, selector, fields) {

            var deferred = $q.defer();

            $http({url: '/web-service/get-children/', method: "POST", data: { pageId: pageId, selector: selector, fields: fields }} )
                .success(function(response){
                    deferred.resolve(response);
            });

            return deferred.promise;    
        },

        /**
         * Gets Children form page
         * @param  {[type]} pageId   parent o where to start from
         * @param  {[type]} selector pw selector, ex: "template=mytemplate, has_parent=1534"
         * @param  {[type]} fields   pw InputFields we want back, if empty we get all, ex: ['lat','lng','zoom']
         * @return {[type]}          [description]
         */
        togglePublished: function (pageId, state) {

            var deferred = $q.defer();

            $http({url: '/web-service/toggle-published/', method: "POST", data: { pageId: pageId, state: state }} )
                .success(function(response){
                    deferred.resolve(response);
            });

            return deferred.promise;    
        },

        /**
         * Save files to a PW page NEEDS TO BE INSTALLED =>  
         *                                 https://github.com/danialfarid/angular-file-upload
         *                                 
         * @param  {[type]} $files         array with the files to upload
         * @param  {[type]} PageID         Id of the page where data will be stored
         * @param  {[type]} InputFieldType ProcessWire type of field where file will be kept, (litIcon, images, audio...)
         * @param  {[type]} removeAll      true-> delete old files
         * @return {[type]}                Saves file to the right folder and assign it to the appropriate pageField
         */
        uploadFile: function($files, PageID, InputFieldType, removeAll) {
            var deferred = $q.defer();

            for (var i = 0; i < $files.length; i++) {
                var file = $files[i];

                if (file.type.indexOf('image') == -1) {
                    alert("La imagen debe ser del tipo JPG o PNG");
                     // $scope.error = 'image extension not allowed, please choose a JPEG or PNG file.'            
                }
                if (file.size > 2097152){
                    alert("La imagen debe pesar menos de 2 MB")
                     // $scope.error ='File size cannot exceed 2 MB';
                }     
                var Fileupload = $upload.upload({
                    url: '/web-service/upload-file/',
                    data: {
                        paginaActual: PageID,   // id de la pagina donde se guarda
                        image_field : InputFieldType,       // nombre del campo de imagenes en pw
                        removeAll : removeAll,              // borra las imagenes antiguas
                    }, 
                    file: file, // un file cada vez

                  }).success(function(data, status, headers, config) {
                    console.debug("data",config);
                    deferred.resolve(config);

                  });
            }//for
            return deferred.promise;            
        },

        /**
         * Creates a JSON file under files assets/PageID with the name PageID.json
         * @param  {[type]} PageID   id of the folder where the file will be saved
         * @param  {[type]} selector pw selector, ex: "template=mytemplate, has_parent=1534"
         * @param  {[type]} fields   pw InputFields we want to save in the json file, ex: ['lat','lng','zoom']
         * 
         * @return {[type]}          [description]
         */
        createJson: function (pageId, title, selector, fields) {
            var promise = $http({url: '/web-service/create-json/', method: "POST", data: { pageId: pageId, title:title, selector: selector, fields: fields }} )
            .then( function(response) { return response.config.data });
            return promise;    
        },        

        /**
         * Modulo especifico para P24 para crear municipio
         * @param  {[type]} pageId [description]
         * @return {[type]}        [description]
         */
        createMunicipioP24: function (pageId) {
            var promise = $http({url: '/web-service/create-municipio-p24/', method: "POST", data: { pageId: pageId}} )
            .then( function(response) { return response.config.data });
            return promise;    
        },   

    }

    return result;
})

