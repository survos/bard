
let url = $table.data('dtAjax');
console.log(url);
if (0)
    $table.DataTable( {
        serverSide: true,
        ordering: false,
        searching: false,
        columns: columns,
        xxajax: {
            url: url
        },
        ajax: function ( data, callback, settings ) {
            var out = [];
            console.log(data);
            console.log(settings);


            var jqxhr = $.ajax({
                dataType: 'json',

                url: url,
                data: {
                    page: 1,
                    itemsPerPage: data.length
                },
                beforeSend: function(request) {
                    console.log("adding ld+json header");
                    request.setRequestHeader("accept", "application/ld+json");
                },
            });

            jqxhr.done(function(hydraData) {
                console.log(data, hydraData);
                callback( {
                    draw: data.draw,
                    data: hydraData['hydra:member'],
                    recordsTotal: hydraData['hydra:totalItems'],
                    recordsFiltered: hydraData['hydra:totalItems'],
                } );
            });

            /*
            for ( var i=data.start, ien=data.start+data.length ; i<ien ; i++ ) {
                out.push( { '@id' : i, 'name': 'name' + i, 'description': 'Desccription of character ' + i} );
                // out.push( [ i, 'name' + i]);
            }
            console.log(out);

            setTimeout( function () {
                callback( {
                    draw: data.draw,
                    data: out,
                    recordsTotal: 1000,
                    recordsFiltered: 1000
                } );
            }, 50 );

             */
        },
        scrollY: 200,
        scroller: {
            loadingIndicator: true
        },
    } );




// let dt = new SurvosDataTable($table, columns);
// dt.render();


console.log('init table');
if (0)
    $workTable.DataTable( {
            // paging: true,
            rowId: '@id',
            serverSide: true,
            /*
                ordering: true,
                searching: true,
                order: [[ 1, "desc" ]],
                columnDefs: [
                    {
                        orderable: true,
                        targets:   0
                    },
                ],

                deferRender: true,
             */
            displayLength: 500, // not sure how to adjust the 'length' sent to the server
            // dom: 'iBft',
            xselect: true,
            xxselect: {
                style:    'multi',
                selector: 'td:first-child'
            },
            // dom: "rtiS",
            // scrollCollapse: true,
            ajax: url,
            XXajax: {
                url: url,
                headers: {
                    Accept : "application/ld+json",
                    "Content-Type": "text/json; charset=utf-8"
                },
                beforeSend: function (request) {
                    console.error(request);
                    request.setRequestHeader("Accept", 'application/ld+json');
                },
                // headers: {'Accept': "application/ld+json"},
                dataFilter: function (data) {
                    var json = JSON.parse(data);
                    console.log(json);
                    json.recordTotal = json['hydra:totalItems'];
                    json.recordsFiltered = json['hydra:totalItems'];
                    json.data = json['hydra:member'];

                    return JSON.stringify(json);
                }
            },
            // ajax: editionUrl,
            columns: workColumns,
            scrollY: 100, // '100px',
            // scrollCollapse: true,
            scroller: {
                loadingIndicator: true
            },
            stateSave: true
        }


    );
