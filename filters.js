	
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
