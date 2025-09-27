<template>
    <div class="p-4">
        <h2 class="text-2xl font-bold mb-4">Stock Entries</h2>

        <!-- Search -->
        <div class="mb-2">
            <input
                v-model="search"
                @input="reloadTable"
                type="text"
                placeholder="Search by item code or name..."
                class="px-3 py-2 border rounded w-64"
            />
        </div>

        <!-- Tabulator Table -->
        <div ref="tabulatorEl"></div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useStore } from "vuex";

// Import CSS
// import "tabulator-tables/dist/css/tabulator.min.css";
// Import JS for side effects
import {TabulatorFull as Tabulator} from 'tabulator-tables';

const tabulatorEl = ref(null);
const table = ref(null);
const search = ref("");
const store = useStore();

// Axios default with auth token
axios.defaults.headers.common["Authorization"] =
  "Bearer " + store.state.auth.token;

const reloadTable = () => {
  table.value.setData("/api/stock", { search: search.value });
};

onMounted(() => {
  // eslint-disable-next-line no-undef
  table.value = new Tabulator(tabulatorEl.value, {
    layout: "fitColumns",
    ajaxURL: "/api/stock",
    ajaxConfig: "GET",
    ajaxParams: { search: "" },
    pagination: "remote",
    paginationSize: 10,
    paginationDataSent: {
      page: "page",
      size: "size",
    },
    ajaxResponse: function(url, params, response) {
      return response.data; // ✅ only return the array
    },
    paginationDataReceived: {
      last_page: "last_page",
      data: "data",
      total_records: "total",
    },
    columns: [
      { title: "Stock No", field: "stock_no", sorter: "number" },
      { title: "Item Code", field: "item_code", sorter: "string" },
      { title: "Item Name", field: "item_name", sorter: "string" },
      { title: "Quantity", field: "quantity", sorter: "number" },
      { title: "Location", field: "location", sorter: "string" },
      { title: "Store Name", field: "store_name", sorter: "string" },
      { title: "In Stock Date", field: "in_stock_date", sorter: "date" },
      {
        title: "Actions",
        formatter: function (cell) {
          return "<button class='delete-btn bg-red-500 text-white px-2 py-1 rounded'>Delete</button>";
        },
        width: 100,
        hozAlign: "center",
        cellClick: function (e, cell) {
          const id = cell.getRow().getData().id;
          if (confirm("Are you sure you want to delete this record?")) {
            axios
              .delete(`/api/stock/${id}`)
              .then(() => {
                cell.getRow().delete();
              })
              .catch((err) => {
                alert(err.response.data.message || "Delete failed");
              });
          }
        },
      },
    ],
  });
});
</script>

<style>
/* Optional Tabulator default styles */
@import "tabulator-tables/dist/css/tabulator.min.css";

/* Customize delete button hover */
.delete-btn:hover {
    opacity: 0.8;
}
</style>
