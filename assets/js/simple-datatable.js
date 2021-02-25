// import {DataTable} from 'simple-datatables';
// require('simple-datatables');
console.log('simple-datatable.js');

const simpleDatatables = require("simple-datatables");
let url = '/api/works.json?page=1&itemsPerPage=10&&title=';
// url = 'https://fiduswriter.github.io/Simple-DataTables/9-fetch-api/demo.json';

class ApiDataTable extends simpleDatatables.DataTable {
    search(query) {
            let rows = this.rows()
            while (this.data.length > 0)
                rows.remove();

            let data = fetchCommunities(query).then((data) => {
                    this.insert({
                        data: data.map(item => Object.values(item))
                    });
                }
            );
    }
}

async function fetchCommunities(searchTerm = '') {
    let resp = await fetch(url+searchTerm);
    return resp.json()
}

function test(query)
{
    fetchCommunities()
        .then(data => {
            if (!data.length) {
                return
            }
            let tableData =  data.map(item => Object.values(item));
            let table = new ApiDataTable(".table", {
                data: {
                    headings: Object.keys(data[0]),
                    data: tableData
                },
            });
        });
}

console.log('Adding Listener');
document.addEventListener("DOMContentLoaded", async (event) => {
    console.log('DOMContentLoaded');
    test();

    return;
    let data = await fetchCommunities();
    // console.log(data);
    let tableData =  data.map(item => Object.values(item));
    let headings = Object.keys(data[0]);
    let table = new simpleDatatables.DataTable("#dynamic", {
        data: {
            headings: headings,
            data: tableData
        },
    })
    table.on('datatable.search', async function (query, matched) {
        console.warn(query, matched);
        // Our workaround doesnt work if there are search results on the client-side:
        // Uncaught TypeError: Node.appendChild: Argument 1 is not an object.
        if (matched.length == 0) {
            // table.clear() doesnt seem to work
            let rows = table.rows()
            while (table.data.length > 0)
                rows.remove();

            let newData = await fetchCommunities(query);
            console.error(newData);
            if (newData.rows.length == 0) {
                table.wrapper.classList.remove("search-results")
                table.setMessage(table.options.labels.noRows)
            } else {
                rows.add(newData)
            }

            // If searching is set to true, we get "no results"
            rows.searchData = []
            table.searching = false
            table.update()
        }
    });
})

