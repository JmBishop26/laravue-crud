<template>
  <div class="btn-container q-gutter-sm">
    <q-btn
      class="btn-action"
      color="primary"
      :icon="fasEye"
      @click="callOpenDialog('View Task', 'VIEW', id)"
    >
      <q-tooltip class="">View</q-tooltip>
    </q-btn>
    <q-btn
      class="btn-action"
      color="positive"
      icon="edit"
      @click="callOpenDialog('Update Task', 'INPUT', id)"
    >
      <q-tooltip class="">Edit</q-tooltip>
    </q-btn>

    <q-btn
      class="btn-action"
      color="negative"
      icon="delete"
      @click="callOpenDialog('Delete this task?', 'CONFIRM', id)"
    >
      <q-tooltip class="">Delete</q-tooltip>
    </q-btn>
  </div>
</template>
<script>
import { defineComponent } from "vue";
import { fasEye } from "@quasar/extras/fontawesome-v5";
export default defineComponent({
  name: "ActionButtons",
  data() {
    return {
      fasEye,
      dialogTitle: "",
      dialogType: "",
      id: this.taskID,
    };
  },
  props: {
    openDialog: Function,
    taskID:Number,
  },
  methods: {
    callOpenDialog(title, type, id) {
      this.dialogTitle = title;
      this.dialogType = type;
      this.id = id
      this.$emit("openDialog", {
        title: this.dialogTitle,
        type: this.dialogType,
        id: this.id
      });
    },
  },
  watch:{
    taskID(newValue){
      this.id = newValue
    }
  },
});
</script>
