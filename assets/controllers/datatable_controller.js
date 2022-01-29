import {Controller} from '@hotwired/stimulus';
import {SurvosDataTable} from 'survos-datatables';
const $ = require('jquery');

export default class extends Controller {

    static targets = ["apiTable", 'htmlTable'];
    static values = {
        apiCall: {type: String, default: 'apiCall'},
    }


    connect() {
        console.log('Connecting to datatable_controller, the base');
        if (this.hasHtmlTableTarget) {
            this.htmlTable(this.htmlTableTarget);
        } else {
            // console.log('btw, no htmlTableTarget');
        }

        if (this.hasApiTableTarget) {
            this.apiTable(this.apiTableTarget);
        } else {
            console.log('btw, no apiTable');
        }

    }

    htmlTable(el) {
        $(el).DataTable();
    }

    columns() {
        console.assert(false, "columns() is abstract and should be defined in the subclass");
        const columns = [];
        columns.push({title: 'marking', data: 'marking'});
        return columns;
    }

    apiTable(el) {


        console.error(el);

        console.error('init with ', el.id);
        const ct = new SurvosDataTable(el, this.columns(), {
            url: this.apiCallValue,
        });
        ct.render();

        return;

        // first, use the library.  then refactor.


        // console.warn('initializeTable ' + el.id);
        // we can avoid this!
        const columnDefs = [
            {
                orderable: false,
                className: 'select-checkbox',
                targets: 0,
            },
            {'width': '18em', 'targets': 2},
            {'width': '30%', 'targets': 3},
        ];



        console.error(this.apiCallValue);

        this.dataTableElement = $(el).DataTable({
            ajax: this.apiRequest({
                url: this.apiCallValue,
            }),
        });

        return;

        ({
            orderCellsTop: true,
            rowId: 'id', // id, @id is also a candidate, it's a string rather than an int
            columns: this.columns,
            columnDefs: [{
                "targets": '_all',
                "defaultContent": "~~"
            }],
            initComplete: (settings, json) => {
                this.initDataTableWidgets();
                console.log('initComplete');
                $('div.loading').remove();
            },

            serverSide: true,
            processing: true,
            paging: true,
            scrollY: '50vh', // vh is percentage of viewport height, https://css-tricks.com/fun-viewport-units/
            // scrollY: true,
            deferRender: true,
            // displayLength: 10000, // not sure how to adjust the 'length' sent to the server
            pageLength: 15,
            dom: '<"js-dt-buttons"B><"js-dt-info"i>ftp',
            buttons: this.buttons,
            scroller: {
                // rowHeight: 20,
                displayBuffer: 20,
                loadingIndicator: true,
            }
        });


        return;



        this.dtbridge = new SurvosDataTable(
            $(el),
            columns,
            {
                url: this.baseUrlValue,
                columnDefs,
                debug: true,
                buttons: false,
            }
        );

        this.dtbridge.render();

        this.dtbridge.dt().on('draw', function () {
            $('.timeago').timeago();
            console.log('attaching transition buttons');

            $('.transition').click(function (e) {
                // console.log(e, e.target);
                const rowId = $(this).closest('tr')
                    .attr('id');
                // this also works: var rowId2 = $(e.target).closest('tr').attr('id');
                const transition = $(e.target).closest('btn')
                    .data('transition');
                console.warn(transition, rowId);
                if (transition === undefined) {
                    console.error('Undefined transition', rowId, $(e.target));
                }
                $('#' + rowId).remove();

                if (transition === 'edit') {
                    const url = $(e.target).closest('btn')
                        .data('url');

                    // const url = Routing.generate('article_edit', {articleId: rowId});
                    const strWindowFeatures = 'menubar=on,location=no,resizable=yes,scrollbars=yes,status=yes';
                    const newWindow = window.open(url, 'Article_' + rowId, strWindowFeatures);
                    // var newWindow = window.open(url);
                    newWindow.focus();
                    return false;


                }
                cb.transitionHeadlines($articleSurvosTable.dt(), transition, rowId, 'article_transition')
                    .done(function (data) {
                        console.log(data);
                    });


            });
        });


    }

    apiRequest(options, apiData) {

        // this was _.defaults(), changed to remove the _ dependency, BUT this may be problematic!!
        //  must be a better way!  https://www.sitepoint.com/es6-default-parameters/
        // $.extend(options, {
        //     headers: {},
        //     dataType: 'json',
        // });
        // $.extend(options.headers, {
        //     Authorization: 'Bearer ' + this.getAccessToken(),
        //     Accept: 'application/ld+json'
        // });
        //
        // /*
        // console.log('------',apiData.itemsPerPage, params.length);
        if (params.start) {
            apiData.page = Math.floor(params.start / params.length) + 1;
        }

        return (params, callback, settings) => {
            console.warn(params, callback, settings);
            // this is the data sent to API platform!

            options.data = this.dataTableParamsToApiPlatformParams(params);
            // this.debug &&
            console.log(params, options.data);
            console.log(`DataTables is requesting ${params.length} records starting at ${params.start}`, options.data);
            console.log(params, options.url, JSON.stringify(options.data));
            console.error('yyy', options, options.url);
            console.assert(options.url, "Missing URL!!");

            // fetch('https://api-to-call.com/endpoint').then(
            //     response => {
            //         if (response.ok) {
            //             return response.json();
            //         }
            //         throw new Error('Request failed!');
            //     }, networkError => {
            //         console.log(networkError.message);
            //     }).then(jsonResponse => jsonResponse);



            var jqxhr = $.ajax(options)
                .fail(function (jqXHR, textStatus, errorThrown) {
                    console.error(textStatus, errorThrown);
                })
                // use .dataFilter instead?  At some point, we should get rid of jQuery and use fetch.
                .done(  (hydraData, textStatus, jqXHR) => {

                    // get the next page from hydra
                    let next = hydraData["hydra:view"]['hydra:next'];
                    var total = hydraData['hydra:totalItems'];
                    var itemsReturned = hydraData['hydra:member'].length;
                    let apiOptions = options.data;

                    if (params.search.value) {
                        console.log(`dt search: ${params.search.value}`);
                    }

                    console.log(`dt request: ${params.length} starting at ${params.start}`);

                    let first = (apiOptions.page-1) * apiOptions.itemsPerPage;
                    let d = hydraData['hydra:member'];
                    // we could get rid of the first part if the starting_at is not at the beginning.
                    // d = d.slice(0, params.length - first);
                    //this.debug &&
                    // this one could be a partial, just json, etc.  Also we don't need it if it's on a page boundary  Usually okay on the first call
                    if ( next && (params.start > 0) ) { // && itemsReturned !== params.length
                        $.ajax({
                            url: next,
                            Accept: 'application/ld+json'
                        }).done( json =>
                        {
                            d = d.concat(json['hydra:member']);
                            this.debug && console.log(d.map( obj => obj.id ));
                            if (this.debug && console && console.log) {
                                console.log(`  ${itemsReturned} (of ${total}) returned, page ${apiOptions.page}, ${apiOptions.itemsPerPage}/page first: ${first} :`, d);
                            }
                            d = d.slice(params.start - first, (params.start - first) + params.length);

                            itemsReturned = d.length;

                            console.log(`2-page callback with ${total} records (${itemsReturned} items)`);
                            console.log(d);
                            callback({
                                draw: params.draw,
                                data: d,
                                recordsTotal: total,
                                recordsFiltered: total // was itemsReturned,
                            });

                            // console.log(params, hydraData, total);
                            // could check hydra:view to see if it's partial
                        });
                    } else {
                        console.log(`D${params.draw} Single page callback with ${itemsReturned} of ${total} records`);
                        console.warn(callback);
                        callback({
                            draw: params.draw,
                            data: d,
                            recordsTotal: total,
                            //  recordsFiltered: itemsReturned,
                            recordsFiltered: total,
                        });

                    }

                    // likely need caching, since in most cases we'll need two requests


                });

            /*
                jqxhr.on('xhr.dt', function ( e, settings, json, xhr ) {
                    console.log(e, settings, json);
                    // Note no return - manipulate the data directly in the JSON object.
                } );
            */

            // return jqxhr;
        }
    }



}
