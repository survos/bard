export default class SurvosDataTable {
    constructor($el, columns, options) {
        if (!options) {
            options = {};
        }
        this.el = $el;
        this.columns = columns;
        this.url = options.url || $el.data('dtAjax');
        console.log("Setting up " + $el.attr('id') + ' with ' + this.url);

        this.debug = false;

    }

    getAccessToken() {
        return $('body').data('accessToken');
    }

    dataTableParamsToApiPlatformParams(params) {
        var apiData = {
            page: 1
        };

        if (params.length) {
            apiData.itemsPerPage = params.length;
        }

        if (params.start) {
            apiData.page = Math.floor(params.start / params.length) + 1;
        }

        return apiData;
    }

    apiRequest(options, apiData) {

        if (typeof options === 'string') {
            options = {
                url: options
            };
        }

        // this was _.defaults(), changed to remove the _ dependency, BUT this may be problematic!!
        //  must be a better way!  https://www.sitepoint.com/es6-default-parameters/
        $.extend(options, {
            headers: {},
            dataType: 'json',
        });
        $.extend(options.headers, {
            Authorization: 'Bearer ' + this.getAccessToken(),
            Accept: 'application/ld+json'
        });

        /*
        console.log('------',apiData.itemsPerPage, params.length);
        if (params.start) {
            apiData.page = Math.floor(params.start / params.length) + 1;
        }
        */

        let that = this;
        return function ( params, callback, settings ) {
            var out = [];
            // console.log(params);
            options.data = that.dataTableParamsToApiPlatformParams(params);


            var jqxhr = $.ajax(options)
                .fail(function(jqXHR, textStatus, errorThrown ) {
                    console.error(textStatus, errorThrown);
                })
                .done(function (hydraData, textStatus, jqXHR) {
                var total = hydraData['hydra:totalItems'];
                    if (this.debug &&  console && console.log ) {
                        console.log(total + " Sample of data:", hydraData['hydra:member'].slice( 0, 3 ) );
                    }
                // console.log(params, hydraData, total);
                // could check hydra:view to see if it's partial
                callback({
                    draw: params.draw,
                    data: hydraData['hydra:member'],
                    recordsTotal: total,
                    recordsFiltered: total,
                });
            });

            return jqxhr;
        }
    }


    render() {
        // var url = this.el.data('ajax'); // or options?
        this.el.DataTable({
            ajax: this.apiRequest({
                url: this.url
            }),
            columns: this.columns,
            serverSide: true,
            scrollY: '300px',
            deferRender: true,
            displayLength: 100, // not sure how to adjust the 'length' sent to the server
            dom: 'iBft',
            scroller: {}
        });
        this.debug && console.warn(this.el.attr('id') + ' rendered!');
        this.debug && console.log(this.url, this.el.data());
    }

}

