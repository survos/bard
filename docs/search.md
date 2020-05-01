# Searching

The goal:

* Display a datatable that uses API Platform with an ElasticSearch data source

The steps:

* As the data is stored in Doctrine, we need a Data Transfer Object (DTO) with the search fields.
* That DTO is used for both indexing and retrieval.
* Should be usable for both doctrine and elasticsearch

## DataTables Setup

```twig
{% set route = 'api_works_get_collection' %} {# change route to call es #}
{% set hydraUrl = path(route) %}
<a target="_blank" href="{{ hydraUrl }}">{{ hydraUrl }}</a>

<table id="work-table" data-dt-ajax="{{ hydraUrl }}"></table>
``` 

```js
const $workTable = $('#work-table');
const workColumns = [
    {title: 'ID', data: '@id'},
    {title: 'Title', data: 'longTitle', filter: 'partial'},
    {title: 'Words', data: 'totalWords', filter: {type: 'input'}},
    {title: 'Year', data: 'year', filter: {type: 'input'}},
    {
        title: 'Actions', data: 'id',
        render(data /* , type, row, meta */) {
            const url = Routing.generate('work_show', {id: data});
            return `<a href=${url}><i class="fas fa-scroll"></i>Show</a>`;
        },
    },
];

const wt = new SurvosDataTable($workTable, workColumns, {
    search: true, 
});
wt.initFooter(); // add the search filters, pass params here from columns?
wt.render();
```

## Indexing

FOSElasticSearch does not yet support ES7, so we'll create the index manually.

First, inspect the WorkOutput DTO (via serialation.yaml? Or annotations?) and create the _map_ that defines the field types.

The make the API call to json-ld and populate the index.  

Does JSON-LD return the field types?  If so, use that!!




