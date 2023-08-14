<template>
  <q-page class="container fit">
    <h1 class="title">To-Do Crud</h1>
    <div class="btn-container">
      <q-btn
        class=""
        color="primary"
        icon="add"
        label="Add Task"
        @click="openDialog({ title: 'Add New Task', type: 'INPUT' })"
      />
    </div>

    <q-table
      flat
      bordered
      card-class="table-card"
      table-class="table"
      table-header-class="table-header"
      :rows="allTasks"
      :columns="columns"
      row-key="id"
      row
    >
      <template v-slot:body-cell-action="props">
        <td>
          <ActionButtons
            :item="props.row"
            :openDialog="openDialog"
            @openDialog="openDialog"
            :taskID="props.row.id"
          />
        </td>
      </template>

      <template v-slot:body-cell-status="props">
        <td class="text-center">
          <q-badge
            v-if="props.row.status === 'ongoing'"
            color="yellow"
            class="text-black"
          >
            Ongoing
          </q-badge>
          <q-badge
            v-else-if="props.row.status === 'complete'"
            color="green"
            class="text-black"
          >
            Complete
          </q-badge>
        </td>
      </template>
    </q-table>
    <DialogTemplate
      :openDialog="isOpen"
      :dialogTitle="dialogTitle"
      :dialogType="dialogType"
      :taskInfo="task"
      @closeDialog="closeDialog"
    />
  </q-page>
</template>

<script>
import { defineComponent } from "vue";
import ActionButtons from "./ActionButtons.vue";
import DialogTemplate from "./DialogTemplate.vue";
import { getAllTasks, getTask } from 'src/utils/functions/Tasks'
const columns = [
  {
    name: "id",
    required: true,
    label: "ID",
    align: "left",
    field: 'id',
    sortable: true,
  },
  {
    name: "title",
    align: "center",
    label: "Title",
    align: "center",
    field: "title",
    sortable: true,
  },
  {
    name: "description",
    align: "center",
    label: "Description",
    field: "description",
    sortable: false,
  },
  {
    name: "date",
    label: "Date Modified",
    field: "date",
    sortable: true,
    align: "center",
    format: (value, item) => {
      // Your condition for formatting the date goes here
      if (item.updated_at === null) {
        return item.created_at;
      } else {
        return item.updated_at; // Default date formatting
      }
    },
  },
  {
    name: "status",
    label: "Status",
    field: "status",
    sortable: true,
    align: "center",
    format: (value, item) => {
      return item.status; // Use the value directly, as we'll customize rendering in the template
    },
  },
  {
    name: "file_name",
    label: "Uploads",
    field: "file_name",
    sortable: false,
    align: "center",
  },
  {
    name: "action",
    label: "Actions",
    field: "action",
    sortable: false,
    align: "right",
  },
];

export default defineComponent({
  name: "ContentTable",
  components: {
    ActionButtons,
    DialogTemplate,
  },
  data() {
    return {
      columns,
      isOpen: false,
      dialogTitle: "",
      dialogType: "",
      taskID: null,
      allTasks:[],
      error:null,
      task:{},
    };
  },
  computed: {
    useGridFormat() {
      return this.$q.screen.sm || this.$q.screen.xs;
    },
  },
  methods: {
    async openDialog({ title, type, id = null }) {
      this.dialogTitle = title;
      this.dialogType = type;
      this.isOpen = true;
      this.taskID = id
      if(this.taskID!==null){
        const response = await getTask(this.taskID)
        this.task = response.data
      }
      console.log(this.dialogTitle, this.dialogType, this.taskID);
    },
    closeDialog(updatedValue) {
      this.isOpen = updatedValue;
      this.task = {}
    },
  },
  async mounted(){
    const response = await getAllTasks()
    this.allTasks = response.data
  }
});
</script>
