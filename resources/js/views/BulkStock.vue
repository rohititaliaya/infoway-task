<template>
  <div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Bulk Stock Entry</h2>

    <ag-grid-vue
      class="ag-theme-alpine"
      style="width: 100%; height: 500px;"
      :theme="'legacy'"
      :columnDefs="columnDefs"
      :rowData="rowData"
      :defaultColDef="defaultColDef"
      rowSelection="multiple"
      :stopEditingWhenCellsLoseFocus="true"
      ref="agGrid"
    />

    <div class="mt-4 flex gap-3">
      <button
        @click="addRow"
        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700"
      >
        Add New Record
      </button>
      <button
        @click="saveAll"
        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
      >
        Save All
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { AllCommunityModule, ModuleRegistry } from "ag-grid-community";
ModuleRegistry.registerModules([AllCommunityModule]);
import { AgGridVue } from "ag-grid-vue3";

import axios from "axios";

const agGrid = ref(null);

const columnDefs = ref([
  { headerName: "Stock No", field: "stock_no", editable: false },
  { headerName: "Item Code", field: "item_code", editable: true },
  { headerName: "Item Name", field: "item_name", editable: true },
  { headerName: "Quantity", field: "quantity", editable: true, type: "numberColumn" },
  { headerName: "Location", field: "location", editable: true },
  {
    headerName: "Store Name",
    field: "store_name",
    editable: true,
    cellEditor: "agSelectCellEditor",
    cellEditorParams: {
      values: ["Store Alpha", "Store Beta", "Store Gamma"],
    },
  },
  { headerName: "In-Stock Date", field: "in_stock_date", editable: true },
]);

// Default col config
const defaultColDef = {
  resizable: true,
  sortable: true,
  filter: true,
};

// Initial row data
const rowData = ref([
  {
    stock_no: 1,
    item_code: "",
    item_name: "",
    quantity: 0,
    location: "",
    store_name: "",
    in_stock_date: new Date().toISOString().slice(0, 10),
  },
]);

// Add new row
function addRow() {
  const nextNo = rowData.value.length + 1;
  rowData.value.push({
    stock_no: nextNo,
    item_code: "",
    item_name: "",
    quantity: 0,
    location: "",
    store_name: "",
    in_stock_date: new Date().toISOString().slice(0, 10),
  });
}

// Save all rows
async function saveAll() {
  agGrid.value.api.stopEditing();

  const rows = [];
  agGrid.value.api.forEachNode((node) => rows.push(node.data));

  // Strip out stock_no (backend handles it)
  const cleanRows = rows.map(({ stock_no, ...rest }) => rest);

  try {
    await axios.post("/api/stock/bulk", { entries: cleanRows });
    alert("Stock entries saved successfully!");
    // Reset grid
    rowData.value = [
      {
        stock_no: 1,
        item_code: "",
        item_name: "",
        quantity: 0,
        location: "",
        store_name: "",
        in_stock_date: new Date().toISOString().slice(0, 10),
      },
    ];
  } catch (err) {
    console.error(err);
    alert("Error saving stock entries");
  }
}
</script>

<style>
@import "ag-grid-community/styles/ag-grid.css";
@import "ag-grid-community/styles/ag-theme-alpine.css";
</style>
