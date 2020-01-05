const $ = require('jquery');
const _ = require('underscore');
require('datatables.net-bs4'); // do we even need this?  Do we extend DataTable?  Or provide utilities for it?

// This used to be SurvosApp, it is now a class with things like thruway removed.  It does not work currently.

// it should be part of SurvosLandingBundle or an independent bundle or javascript package.

// It requires api-platform (composer req api), and datatables+bootstrap (yarn add datatables.net-bs4, plus buttons, etc.

export default class DTApi {
// the constructor should be
// initObjectDatatable: function ($tableEl, columns, options) {

/**
 * survos global app object
 * @type {Object}
 */
// window.dtApi = {

    /**
     * you can register callbacks here so
     * if components request widgets re-registration (initComponents)
     * it will be called too
     */
    // initCallbacks: [],

    /**
     * register controls after page is loaded
     * and after each page reload (ajax)
     * @return {[type]} [description]
     */

    constructor($el, columns, options) {
        this.el = $el;
        this.columns = columns;

    }

    register(container) {
        this.debug = !!container.data('debug');
        this.initLoadedElement(container);
        this.initCollectionContainers(container);
    }
    /**
     * checks if object is function
     */
    isFunction(object) {
        return typeof(object) === 'function';
    }

    handleLazyLoader(el) {
        this.debug && console.log('Registering registerLazyLoader', el);

        let $el = $(el),
            url = $el.data('ajax');
        $el.addClass('loading');
        $el.load(url, function () {
            $el.removeClass('loading');
        });

    }

    handleAjaxButton(el) {
        this.debug && console.log('Registering handleAjaxButton', el);

        var $el = $(el),
            url = $el.data('ajax'),
            target = $($el.data('target'));
        $el.on('click', function (e) {
            e.preventDefault();
            this.debug && console.log('loading', url);
            if (target.length) {
                target.addClass('loading');
                target.load(url, function () {
                    $el.removeClass('loading');
                });
            } else {
                $.ajax(url);
            }
        }.bind(this));

    }

    initLoadedElement(container) {
        this.initDataTables(container);
        this.initComponents(container);
    }



    /**
     * init bootstrap popovers + gallery
     * @return {[type]} [description]
     */

    /**
     * Children of element with data-collection-container attribute should be subforms representing the items
     * in the collection. The value of the attribute should be the type of the item ("protocol", for example).
     * Clicking the "Add" button appends a new child with HTML coming from the data-prototype value of the
     * collection container.
     *
     * @param container
     */
    initCollectionContainers(container) {
        $('[data-collection-container]', container).each(function () {
            var $collectionContainer = $(this),
                type = $collectionContainer.data('collectionContainer'),
                templateHtml = $collectionContainer.data('prototype')
                    .replace(/__name__/g, '<%= n %>'),
                template = _.template(templateHtml);
            $('<button/>').attr({type: 'button'})
                .addClass('btn btn-success')
                .text('Add ' + type.substr(0, 1).toUpperCase() + type.substr(1))
                .insertAfter($collectionContainer.is('tbody') ? $collectionContainer.parent() : $collectionContainer)
                .on('click', function () {
                    // Find index of last child
                    var $lastChild = $collectionContainer.children().last(),
                        m = $lastChild.length && $lastChild.find('input').attr('name').match(/\[(\d+)\]/),
                        n = m ? +m[1] + 1 : 0;
                    $collectionContainer.append(template({n: n}));
                    survosApp.initLoadedElement($collectionContainer.children().last());
                });
        }).on('click', '.delete', function (evt) {
            var $button = $(this),
                $child = $(evt.delegateTarget).children().has(this);
            if ($button.hasClass('btn-danger')) {
                $button.addClass('btn-default')
                    .removeClass('btn-danger');
                $child.addClass('text-muted danger')
                    .find('input').prop('disabled', true);
            } else {
                $button.addClass('btn-danger')
                    .removeClass('btn-default');
                $child.removeClass('text-muted danger')
                    .find('input').prop('disabled', false);
            }
        });
    }

    /**
     * handle datatables globally
     * @return {[type]} [description]
     */
    initDataTables(container) {
        var that = this;
        container.find('.table-datatable').each(function () {
            that.debug && console.log('initDataTables', this);
            that.initSingleDatatable($(this));
        });

    }

    initDataTableSearch(container, $table, columns) {
        var that = this;
        container.find('[data-bind-datatable="' + $table.attr('id') + '"]').each(function (a, field) {
            var $field = $(field);

            // do not add listener if already registered
            if ($field.data('registered')) {
                //console.log('trying to register datatable search twice');
                return;
            }
            $field.data('registered', true);
            var fieldName = $field.data('field');
            if (!fieldName) {
                that.handleGlobalSearch($table, $field);
            } else {
                var columnIndex = _.findIndex(columns, function (column) {
                    return fieldName === column.data;
                });
                that.handleFieldSearch($table, $field, columnIndex);
            }
        });
    }

    handleGlobalSearch($table, $field) {
        var that = this;
        var filterGlobal = _.debounce(function () {
            that.debug && console.log('filterGlobal');
            that.removeTableSelection($table);
            $table.dataTable().api().search($field.val(), false, true).draw();
        }, 400);
        $field.on('keyup change', filterGlobal);
        if ($field.val()) {
            filterGlobal();
        }
        // needed to expand search field on focus
        $field.on('focus', function () {
            $field.parent().addClass('focused');
        }).on('blur', function () {
            $field.parent().removeClass('focused');
        });

        // keep reference (for footer filters)
        $table.data('search-field', $field);

        $($table).closest('.dataTables_wrapper').addClass('hide-filters');
    }

    handleFieldSearch($table, $field, columnIndex) {
        var that = this;
        function getValue($el) {
            if ($el.is(':checkbox')) {
                return $el.filter(':checked').val();
            } else if ($el.is('select')) {
                return $el.val();
            } else {
                return $el.val();
            }
        }
        var filter = function () {
            that.removeTableSelection($table);
            var value = getValue($field);
            $table.dataTable().api().column(columnIndex).search(value).draw();
        };
        $field.on('change', filter);
        if (getValue($field)) {
            filter();
        }
    }

    initDataTableWidgets(container, $table) {
        var info = $table.dataTable().api().page.info();
        var card = $table.closest('.card');
        card.find('[data-totals="rows"]').html(info.recordsDisplay);
        card.find('[data-totals="progress"]').html(Math.round((info.start / info.recordsDisplay) * 100));
        this.debug && console.log('page info', info);
    }

    /**
     * add debug link and refresh button in table card heading
     * @param $table
     * @param url
     */
    handleDataTableLinks($table, url) {
        var card = $table.closest('.card');
        if (card.length) {
            var cardHeading = card.find('.card-heading');
            if (url && cardHeading.length) {
                cardHeading.find('.debug-link, .reload-link').remove();
                if (this.debug) {
                    var newA = $('<a>');
                    newA.attr({href: url, target: '_blank', title: $table.attr('id')})
                        .addClass('widget-toolbar debug-link')
                        .html('<i class="fa fa-link"></i>');
                    cardHeading.prepend(newA);
                }
                var newB = $('<a>');
                newB.attr({href: '#', title: $table.attr('id')})
                    .addClass('widget-toolbar reload-link')
                    .html('<i class="fa fa-refresh"></i>');
                newB.on('click', function (event) {
                    $table.DataTable().ajax.reload();
                    event.preventDefault();
                    return false;
                });
                cardHeading.prepend(newB);
            }
        }
    }

    isApiUrl(url) {
        return /\/api2\.0\//.test(url);
    }

    getAccessToken() {
        return $('body').data('accessToken');
    }

    apiRequest(options) {
        if (typeof options === 'string') {
            options = {
                url: options
            };
        }
        _.defaults(options, {
            headers: {},
            dataType: 'json'
        });
        _.defaults(options.headers, {
            Authorization: 'Bearer ' + this.getAccessToken(),
            Accept: 'application/ld+json'
        });
        return $.ajax(options);
    }

    handleSafeRender(columns) {
        var safeRender = function (data) {
            return data ? data : '';
        };

        _.each(columns, function (col) {
            if (col.render === undefined) {
                col.render = safeRender;
            }
        });
    }

    handleCriteriaSearch(columns) {
        _.each(columns, function (col) {
            if (col.criteriaSearch !== undefined) {
                console.log('handleCriteriaSearch', col);
                col.title += '<br><input class="criteria-search" type="text" name="criteria[' + col.data + ']">';
                //col.title = function (cell, cellData, rowData, rowIndex, colIndex) {
                //    var input = $('<input type="text">').addClass('criteria-search').attr('name','criteria[' + col.data + ']');
                //    input.appendTo($(cell));
                //};
            }
        });
    }

    handleTimeago(columns) {
        _.each(columns, function (col) {
            if (col.timeago) {
                col.render = survosApp.timeagoRender;
                delete col.timeago;
                col.className = 'text-nowrap';
            }
        });
    }

    // should probably be something like handleCharts
    handleCompliance(columns) {
        _.each(columns, function (col) {
            // @todo: immplement this so compliance is easier to call
            if (col.compliance) {
                $(".daily-compliance-bar-chart").peity("bar", {
                    width: 128,
                    fill: function (value) {
                        var threshold = $(this).data('threshold') || 60;
                        return value > threshold ? "green" : "red"
                    }
                })
            }
        })
    }

    handleNumbers(columns) {
        _.each(columns, function (col) {
            if (col.number) {
                col.render = renderNumber;
                delete col.number;
                col.className = 'float-right';
            }
        });

        function renderNumber(data) {
            return data == null ? '' : data.toLocaleString();
        }
    }

    handleDataTableInitComplete() {
        var $table = this;
        var handleCriteriaSearchInput = function (input) {
            var $input = $(input);
            $input.on('click', function (e) {
                e.stopPropagation();
            }).on('keyup', _.debounce(function () {
                $table.dataTable().api().ajax.reload();
            }, 400));
        };

        _.each(this.closest('.dataTables_wrapper').find('.dataTables_scrollHead input.criteria-search'), function (input) {
            handleCriteriaSearchInput(input);
        });
    }

    handlePreXhrCall (e, settings, data) {
        $(this).closest('.card').addClass('loading');
    }

    handleXhrCall() {
        $(this).closest('.card').removeClass('loading');
    }

    /**
     * init fully javascript-driven datatable
     * @param $tableEl
     * @param columns (can also pass options here and set "columns" in it)
     * @param options
     * @returns {*}
     */
    initObjectDatatable($tableEl, columns, options) {
        var drawCallback, dataCallback;
        if (typeof $tableEl === 'string') {
            $tableEl = $($tableEl);
        }
        if (!$tableEl || !$tableEl.length) {
            return $tableEl;
        }
        if (!options) {
            options = {};
        }
        if ($.isPlainObject(columns)) {
            options = columns;
            columns = null;
        }
        else {
            options.columns = columns;
        }
        options.initComplete = this.handleDataTableInitComplete;
        if ($tableEl.data('ajax')) {
            options.ajax = $tableEl.data('ajax');
            $tableEl.removeData('ajax').removeAttr('data-ajax');
        }
        var extraColumns = $tableEl.data('extra-columns');
        if (extraColumns) {
            _.each(extraColumns, function (col) {
                col.render = function (data) {
                    if (_.isArray(data) || _.isObject(data)) {
                        data = JSON.stringify(data);
                    }
                    return data === undefined ? '' : data;
                };
                columns.push(col);
            });
        }
        var initFooter = function ($tableEl) {
            var footer = $tableEl.find('tfoot');
            if (footer.length > 0) {
                return; // do not initiate twice
            }

            var handleSelect = function (column) {
                var select = $('<select class="form-control"></select>');
                var createOptions = function(items) {
                    select.empty();
                    select.append('<option value="">Select option</option>');
                    _.each(items, function (label, value) {
                        select.append('<option value="'+value+'">'+label+'</option>');
                    });
                };

                if (column.filter.choices) {
                    createOptions(column.filter.choices);
                } else if (column.filter.choices_url) {
                    survosApp.apiRequest({url: column.filter.choices_url}).then(createOptions);
                }

                return select;
            };
            var handleInput = function (column) {
                var input = $('<input class="form-control" type="text">');
                input.attr('placeholder', column.filter.placeholder || 'Enter value');
                return input;
            };

            this.debug && console.log('adding footer');
            var tr = $('<tr>');
            var that = this;
            $(columns).each(function (index, column) {
                var td = $('<td>');
                if (column.filter !== undefined) {
                    var el;
                    if (column.filter === true || column.filter.type === 'input') {
                        el = handleInput(column);
                    } else if (column.filter.type === 'select') {
                        el = handleSelect(column);
                    }
                    that.handleFieldSearch($tableEl, el, index);
                    td.append(el);
                }
                tr.append(td);
            });
            footer = $('<tfoot>');
            footer.append(tr);
            $tableEl.append(footer);
        }.bind(this);

        if (options.drawCallback) {
            drawCallback = options.drawCallback;
            delete options.drawCallback;
        }
        if (options.dataCallback) {
            dataCallback = options.dataCallback;
            delete options.dataCallback;
        }


        _.defaults(options, {
            deferRender: true,
            dom: options.disableScroller ? 'lfrtip' : 'frti',
            scroller: !options.disableScroller,
            drawCallback: function () {
                this.initComponents($tableEl);
                this.initDataTableWidgets($('body'), $tableEl);
                if (typeof drawCallback === 'function') {
                    _.defer(drawCallback);
                }
            }.bind(this),
            preDrawCallback: function () {
            }.bind(this),
            serverSide: options.ajax ? true : false
        });

        console.log(options);

        // init search field in the card header
        this.initDataTableSearch($('body'), $tableEl, options.columns);
        initFooter($tableEl);
        this.debug && console.log('datatable options', options);
        if ((typeof options.ajax) === 'string') {
            this.handleDataTableLinks($tableEl, options.ajax);

            $tableEl.removeData('ajax').attr('data-ajax', null); // keep DataTables from overwriting this
            options.ajax = {
                url: options.ajax,
                data: function (data) {
                    // Get rid of unnecessary URL parameters
                    // if hook defined, then call it first
                    if (typeof dataCallback === 'function') {
                        data = dataCallback(data);
                    }
                    if (data.columns) {
                        data.columns.forEach(function (column) {
                            if (!column.name) {
                                delete column.name;
                            }
                            delete column.orderable;
                            delete column.searchable;
                            if (!column.search.regex) {
                                delete column.search.regex;
                            }
                            if (!column.search.value) {
                                delete column.search.value;
                            }
                        });
                    }
                    if (data.search) {
                        if (!data.search.regex) {
                            delete data.search.regex;
                        }
                        if (!data.search.value) {
                            delete data.search.value;
                        }
                    }
                    return data;
                }
            };
        }

        // console.log("Checking for API url", options.ajax.url);

        if (options.ajax && options.ajax.url && this.isApiUrl(options.ajax.url)) {
            var url = options.ajax.url,
                oldData = options.ajax.data;
            console.log("API URL!", url);

            options.ajax = function (params, callback) {
                params = oldData(params); // remove junk
                var apiData = $(this).data('query-params') || {},
                    columns = _.map(params.columns, function (c) {
                        var column = c.name || c.data;
                        if (c.search.value) {
                            apiData[column] = c.search.value;
                        }
                        return column;
                    });
                apiData.itemsPerPage = params.length;
                console.log('------',apiData.itemsPerPage, params.length);
                if (params.start) {
                    apiData.page = Math.floor(params.start / params.length) + 1;
                }
                if (params.search && params.search.value) {
                    apiData.q = params.search.value;
                }
                if (params.order) {
                    apiData.order = {};
                    params.order.forEach(function (o) {
                        var name = columns[o.column]; // translate number to name
                        apiData.order[name] = o.dir;
                    });
                }
                if (typeof dataCallback === 'function') {
                    apiData = dataCallback(apiData);
                }
                survosApp.apiRequest({
                    url: url,
                    data: apiData
                }).then(function (data) {
                    data.data = data['hydra:member'];
                    delete data['hydra:member'];
                    data.draw = params.draw;
                    data.recordsTotal = data['hydra:totalItems']; // real value not available?
                    data.recordsFiltered = data['hydra:totalItems'];
                    delete data['hydra:totalItems'];
                    delete data['hydra:view'];
                    delete data['@context'];
                    delete data['@id'];
                    delete data['@type'];
                    callback(data);
                }).catch(console.error);
            };
        }
        this.debug && console.log('dt options ', options);
        if (!options.disableScroller) {
            this.debug && console.log('enabling scroller ' + $tableEl.attr('id'));
            _.defaults(options, {
                scrollCollapse: true,
                scrollY: options.height ? options.height : 300,
                scrollX: true,
                deferRender: true
            });
        }
        delete options.disableScroller;

        this.debug && console.log('init dt', $tableEl, options);

        // fix card overflow for tables (no overflow hidden)
        $tableEl.closest('.card-body').addClass('overflow');

        this.handleCriteriaSearch(options.columns);
        this.handleTimeago(options.columns);
        this.handleNumbers(options.columns);
        this.handleSafeRender(options.columns);
        this.datatables.push($tableEl.DataTable(options));
        $tableEl.on('preXhr.dt', this.handlePreXhrCall).on('xhr.dt', this.handleXhrCall);
        $tableEl.on('preXhr.dt', this.handlePreXhrCall).on('xhr.dt', this.handleXhrCall);
        return $tableEl; // for chaining
    }

    removeTableSelection($tableEl) {
        this.debug && console.log('removeTableSelection');
        var rows = $tableEl.DataTable().rows();
        if (rows.deselect) {
            rows.deselect();
        }
    }

    /**
     * re-usable datatable initialization function
     * @param dataTableEl
     * @returns {*}
     */
    initSingleDatatable(dataTableEl) {
        var columns = dataTableEl.find('thead > tr:first-child > th').map(function () {
            var columnOptions = {},
                data = $(this).data(),
                html, templateFn;
            html = data.template ||
                (data.timeago && data.data && ('<time class="timeago" datetime="<%= ' + data.data + ' %>"><%= ' + data.data + ' %></time>'));
            if (html) {
                templateFn = _.template(html);
                columnOptions.data = function (row) {
                    var values = _.extend({
                        Routing: Routing,
                        _: _
                    }, row);
                    return templateFn(values);
                };
            }
            return columnOptions;
        });
        this.initObjectDatatable(dataTableEl, columns);
        return dataTableEl;
    }

    /**
     * init other components
     * @return {[type]} [description]
     */
    initComponents(container) {
        this.initPopovers(container);
        this.debug && console.log('initComponents', container);
        var that = this; // save to use in inner functions

        /**
         * init timeago
         */
        jQuery.timeago.settings.allowFuture = true;

        if (0) {
            container.find('time.timeago').timeago();
            container.find('abbr.timeago').timeago();
        }
        var $select2 = container.find('.select2');
        if ($select2.length) {
            $select2.select2();
        }
        container.find('[data-update-timer]').each(function (a, b) {
            that.handlePeriodicUpdater(b);
        });

        if ($.fn.peity) {
            container.find('.pie').peity('pie');
        }

        var $clockpicker = container.find('.clockpicker');
        if ($clockpicker.length) {
            $clockpicker.clockpicker({
                placement: 'top',
                donetext: 'Done',
                twelvehour: true
            });
        }

        $(this.initCallbacks).each(function (idx, fn) {
            if (that.isFunction(fn)) {
                that.debug && console.log('calling initComponents callback');
                fn(container);
            }
        });

        /**
         * handle form wizards
         * @type {[type]}
         */
        var $wizard = container.find('.wizard');
        if ($wizard.length) {
            $wizard.wizard();
            // hack to enable direct click on tabs (https://github.com/ExactTarget/fuelux/issues/175)
            // console.log($wizard);
            // $wizard.off('click', 'li.complete');

            var key = '_wizard';
            var value = getUrlParameter(key) || getUrlParameter(encodeURIComponent(key));
            if (null !== value) {
                let el = $wizard.find('li[data-target="#' + value + '"]');
                if (el.length) {
                    let step = el.data('step');
                    $wizard.wizard('selectedItem', {step: step});
                }
            }

            $wizard.on('click', 'li', function () {
                $wizard.wizard('selectedItem', {step: $(this).data('step')});
            });

            $wizard.on('click', '.btn-finish', function () {
                $wizard.trigger('finished');
            });

            var $form = $('.form-wizard'),
                btnNext = $form.find('.btn-next');
            $wizard.on('actionclicked.fu.wizard', function (e, data) {
                var step = data.step,
                    increment = data.direction === 'next' ? 1 : -1;
                e.preventDefault();
                while (true) {
                    step += increment;
                    if ($wizard.find('li[data-step=' + step + ']').is(':visible')) {
                        break;
                    }
                }
                $wizard.wizard('selectedItem', {step: step});
            });
            $wizard.on('changed.fu.wizard', function (e, data) {
                var lastStep = $wizard.find('li[data-step]:visible:last').data('step');
                if (data.step >= lastStep) {
                    btnNext.prop('disabled', true);
                } else {
                    btnNext.prop('disabled', false);
                }
                survosApp.initExpandingTextareas($wizard);

                var paramValue = $wizard.find('li[data-step=' + data.step + ']').data('target');
                paramValue = paramValue.replace('#', '');
                setUrlParameter('_wizard', paramValue);
            });

            $wizard.on('finished', function () {
                var form = $form[0];
                if (form.checkValidity()) {
                    form.submit();
                } else {
                    // find any failing input and switch to the correct tab
                    $form.find('input, textarea, select').each(function (idx, input) {
                        if (input.validity && !input.validity.valid) {
                            var tab = $(input).closest('[data-step]');
                            $wizard.wizard('selectedItem', {step: tab.data('step')});
                        }
                    });
                }
            });
        }

        function getUrlParameter(name) {
            var url = window.location.href;
            name = name.replace(/[\[\]]/g, "\\$&");
            var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results || !results[2]) return null;
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }

        function setUrlParameter(name, value) {
            var searchParams = new URLSearchParams(window.location.search)
            searchParams.set(name, value);
            var newRelativePathQuery = window.location.pathname + '?' + searchParams.toString();
            history.pushState(null, '', newRelativePathQuery);
        }

        // Highlight divs from URL parameters (for tutorials)
        var highlightFields = getUrlParameter('highlightFields'),
            highlightDivs = getUrlParameter('highlightDivs');
        if (highlightFields) {
            highlightFields.split(',').forEach(function (id) {
                $('#' + id).closest('.form-group').addClass('highlight');
            });
        }
        if (highlightDivs) {
            highlightDivs.split(',').forEach(function (id) {
                $('#' + id).addClass('highlight');
            });
        }

        /**
         * prepare templates for any node which defines it
         */
        var registerTemplate = function (templateNode) {
            var node = $(templateNode);
            // prepare template from html in selector
            this.debug && console.log('registering template ' + node.data('template-selector'));
            node.data('template', _.template(container.find(node.data('template-selector')).html()));
        }.bind(this);

        container.find('[data-template-selector]').each(function (a, b) {
            registerTemplate(b);
        });

        if (0)
        moment.locale && moment.updateLocale('en', {
            longDateFormat: {
                LT: 'h:mm A',
                L: 'YYYY-MM-DD',
                l: 'YYYY-M-D',
                LL: 'MMMM Do YYYY',
                ll: 'YYYY MMM D',
                LLL: 'YYYY MMMM Do LT',
                lll: 'YYYY MMM D LT',
                LLLL: 'dddd, MMMM Do YYYY LT',
                llll: 'ddd, MMM D YYYY LT'
            }
        });

        /**
         * handle any button on jarvis header which toggles toolabs
         * @param btn
         */
        var handleWidgetToolbarBtn = function (btn) {
            var $btn = $(btn),
                box = container.find('#' + $btn.data('toggle-widget-toolbar'));
            $btn.on('click', function () {
                $btn.toggleClass('active');
                box.toggleClass('show', $btn.hasClass('active'));
                if ($btn.data('disable-inputs') !== undefined) {
                    // if hidden - disable inputs to not post them
                    box.find('[name]').prop('disabled', !$btn.hasClass('active'));
                }
            });
        };

        container.find('[data-toggle-widget-toolbar]').each(function (a, b) {
            handleWidgetToolbarBtn(b);
        });

        var handleToggleSidebar = function (btn) {
            var $btn = $(btn),
                $el = $($btn.data('toggle-sidebar-class-el')),
                $this = this,
                toggleClass = $btn.data('toggle-class') ? $btn.data('toggle-class') : 'hide';

            $btn.data('original-html', $btn.html());
            if ($el.hasClass(toggleClass)) {
                $btn.html($btn.data('toggle-html'));
            } else {
                $btn.html($btn.data('original-html'));
            }
            $btn.on('click', function (e) {
                e.preventDefault();
                // hide after first toggle
                if ($btn.data('toggle-hide-remove')) {
                    $btn.addClass(toggleClass);
                }
                $el.toggleClass(toggleClass);
                // handle element content change on toggle
                $this.updateUserSession({
                    sidebar_collapsed: $el.hasClass(toggleClass) ? 1 : 0
                });

                if ($btn.data('toggle-html')) {
                    if ($el.hasClass(toggleClass)) {
                        $btn.html($btn.data('toggle-html'));
                    } else {
                        $btn.html($btn.data('original-html'));
                    }
                }
                survosApp.adjustDataTables();
            });
        }.bind(this);

        container.find('[data-toggle-sidebar-class-el]').each(function (idx, btn) {
            handleToggleSidebar(btn);
        });

        var handleToggleRow = function (link) {
            var $btn = $(link),
                url = $btn.data('url'),
                tr = $btn.closest('tr');
            $btn.on('click', function (e) {
                e.preventDefault();
                tr.toggleClass('row-expanded');
                if (tr.hasClass('row-expanded')) {
                    // add new row just after expanded
                    var newTr = $('<tr class="row-details">');
                    newTr.insertAfter(tr);
                    var newTd = $('<td colspan="20">');
                    newTr.append($('<td class="padding">'));
                    newTr.append(newTd);
                    newTd.html('<project class="loader"><i class="fa fa-spinner fa-spin"></i> Loading data</project>');
                    newTd.load(url, null, function () {
                        that.initComponents(newTd);
                    });
                } else {
                    if (tr.next().hasClass('row-details')) {
                        tr.next().remove();
                    }
                }
            });
        };
        container.find('[data-toggle-row]').each(function (idx, link) {
            handleToggleRow(link);
        });

        /**
         * handle donut charts
         * @param donut
         */
       // each(container.find('[data-donut],[data-donuturl]'), this.initDonuts);
    }

    /*
     * LOAD SCRIPTS
     * Usage:
     * Define function = myPrettyCode ()...
     * loadScript("js/my_lovely_script.js", myPrettyCode);
     */
    loadScript(scriptName, callback, attr) {
        var useCdn = /^\/[^\/]/.test(scriptName); // local URL
        if (scriptName.src && !attr) {
            attr = scriptName;
            scriptName = scriptName.src;
            delete attr.src;
        }
        if (!this.jsArray[scriptName]) {
            this.jsArray[scriptName] = true;

            // adding the script tag to the head as suggested before
            var body = document.getElementsByTagName('body')[0],
                script = document.createElement('script');
            script.type = 'text/javascript';
            if (useCdn) {
                scriptName = (this.cdnBasePath || '') + scriptName + '?' + this.version;
            }
            script.src = scriptName;
            if (attr) {
                if (Array.isArray(attr)) { // not sure why we even have array, since data attributes must be distinct
                    $(attr).each(function (a, b) {
                        script.dataset[b.key] = b.val;
                    });
                }
                else { // object
                    _.each(attr, function (val, key) {
                        script.dataset[key] = val;
                    });
                }
            }

            // then bind the event to the callback function
            // there are several events for cross browser compatibility
            script.onload = callback;

            // fire the loading
            body.appendChild(script);
        } else if (callback) {
            // changed else to else if(callback)
            //console.log("JS file already added!");
            //execute function
            callback();
        }
    }

    loadScripts(scriptNames, callback) {
        var scriptName = scriptNames.shift();
        if (scriptNames.length) {
            callback = this.loadScripts.bind(this, scriptNames, callback);
        }
        if (scriptName) {
            this.loadScript(scriptName, callback);
        }
        else {
            callback();
        }
    }

    initExpandingTextareas(container) {
        // $('textarea', container).expanding(); // @todo-dmitry, fix expanding
    }


    nameToCode(name, length, separator, trimmed) {
        if (length == null) {
            length = 32;
        }
        if (trimmed == null) {
            trimmed = true;
        }
        var code = name == null ? '' : name.toLowerCase()
            .replace(/[^a-z\d\-]+/g, '_')
            .replace(/^_/, '');
        if (length) {
            code = code.substr(0, 32);
        }
        if (trimmed) {
            code = code.replace(/_$/, '');
        }
        if (separator) {
            code = code.replace('_', separator);
        }
        return code;
    }

    arrayToTable(data) {
        var t = $('<table>').addClass('table table-condensed table-striped');
        _.each(data, function (val, key) {
            var r = $('<tr>');
            t.append(r);
            r.append($('<th>').html(key));
            r.append($('<td>').html(val));
        });

        return t[0].outerHTML;
    }

    link(url, text) {
        if (!text) {
            url = text;
        }
        var $a = $('<a/>').attr('href', url).text(text);
        return $('<span/>').html($a).html();
    }

    timeagoRender(isoTime, type) {
        if (typeof isoTime === 'undefined') {
            isoTime = null;
        }
        if (type && type !== 'display') {
            return isoTime; // for sorting, mainly
        }
        return isoTime ? '<time class="timeago" datetime="' + isoTime + '">' + isoTime + '</time>' : '';
    }

    initDonuts(donut, callback) {
        var translateColors = function (donutData) {
            var reservedColors = {
                'expired': '#ff0000',
                'complete': '#008000'
            };
            var otherColors = ['#dbe949', '#de7b61', '#190ffe', '#f3f9bb', '#e502b6', '#aeb795', '#d6ab32', '#71a7b9', '#eddbb3'];
            var colors = [];
            _.each(donutData, function (data) {
                var parsedLabel = $('<a>' + data[0] + '</a>').text();
                if (reservedColors[parsedLabel]) {
                    colors.push(reservedColors[parsedLabel]);
                } else {
                    colors.push(otherColors.shift());
                }
            });
            return colors;
        };
        var $donut = $(donut),
            donutData = $donut.data();

        var initWithData = function (donutData) {
            if (donutData.donut && donutData.donut.length) {
                this.debug && console.log('initializing donut', donut, donutData);
                var colors = translateColors(donutData.donut);

                jQuery.jqplot($donut.attr('id'), [donutData.donut],
                    {
                        seriesColors: colors,
                        seriesDefaults: {
                            // Make this a pie chart.
                            renderer: jQuery.jqplot.PieRenderer,
                            rendererOptions: {
                                // Put data labels on the pie slices.
                                // By default, labels show the percentage of the slice.
                                showDataLabels: true,
                                padding: 6,
                                startAngle: -90,
                                dataLabels: donutData.labels || 'value'
                            }
                        },
                        grid: {drawBorder: false, background: 'transparent', shadow: false},
                        gridPadding: {top: 0, bottom: 0, left: 0, right: 0},
                        legend: {show: !donutData.hideLegend, location: donutData.legend || 's'}
                    }
                );
            }
            if (typeof callback === 'function') {
                callback(donutData.donut);
            }
        };
        if (donutData.donuturl) {
            $.ajax(donutData.donuturl).then(function (data) {
                donutData.donut = data;
                initWithData(donutData);
            });
        } else if (donutData.donut) {
            initWithData(donutData);
        }
    }

    populateTable($table, values) {
        console.log('populateTable', $table, values);
        if (!values) {
            values = {};
        }
        $.each(values, function (key, value) {
            if (value && typeof value === 'object' && value.id) {
                var newKey = key + 'Id';
                if (values[newKey] == null) {
                    values[newKey] = value.id;
                }
            }
        });
        $table.find('[data-field]').each(function () {
            var $cell = $(this),
                fieldName = $cell.data('field'),
                type = $cell.data('type'),
                value = values[fieldName];
            $cell.html(survosApp.display(value, type));
            if (type === 'timeago') {
                $('time', $cell).timeago();
            }
        });
    }

    display(value, type) {
        var format, m, isoTime, route, params;
        if (value == null) {
            return '—';
        }
        if (type === 'datetime' || type === 'date' || type === 'time' || type === 'timeago') {
            if (value.date) { // kluge for DateTime converted to JSON in PHP
                value = value.date;
            }
            format = type === 'datetime' ? 'YYYY-MM-DD LT' : (type === 'date' ? 'YYYY-MM-DD' : 'LT');
            m = moment.utc(value);
            if (type === 'timeago') {
                isoTime = m.format();
                value = '<time datetime="' + isoTime + '">' + isoTime + '</time>';
            }
            else {
                /*
                if (type !== 'date') {
                    m.tz(timezone);
                }
                */
                value = m.format(format);
            }
        }
        else if (typeof value === 'boolean' || typeof value === 'object') {
            return '<pre>' + JSON.stringify(value, null, 1) + '</pre>';
        }
        else if (type && (m = type.match(/^(\w+)_id$/))) {
            route = m[1] + '_show';
            params = {};
            params[m[1] + 'Id'] = value;
            value = $('<a/>').attr({href: Routing.generate(route, params)})
                .text(value);
            value = $('<div/>').html(value).html(); // convert to escaped string
        }
        return value;
    }
}

