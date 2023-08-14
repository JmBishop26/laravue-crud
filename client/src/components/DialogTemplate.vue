<template>
  <div class="q-pa-md q-gutter-sm dialog-container">
    <q-dialog
      v-if="type === 'INPUT' || type === 'VIEW'"
      class="main-dialog"
      v-model="isOpen"
      persistent
      transition-show="scale"
      transition-hide="scale"
    >
      <q-card class="dialog-card">
        <q-card-section class="title-section">
          <div class="text-h6 title-text">{{ header }}</div>
        </q-card-section>

        <q-card-section class="body-section">
          <p>Title</p>
          <q-input
            class="input text-input"
            outlined
            v-model="title"
            label="What is your task today?"
            :readonly="type === 'VIEW'"
            :rules="[required, minLength]"

          />
          <p>Description</p>
          <q-input
            class="input textarea-input"
            outlined
            v-model="description"
            label="Describe your task (optional)"
            :readonly="type === 'VIEW'"
          />
          <p>Status</p>
          <q-toggle
            class="input toggle-input"
            v-model="status"
            label="Complete"
            color="primary"
            :disable="type === 'VIEW'"
          />
          <p>File</p>
          <span v-if="type==='VIEW'">{{ file[0]['name']}}</span>
          <q-file
            class="input file-input"
            filled
            bottom-slots
            v-model="file"
            label="Upload file related to your task"
            counter
            v-if="type==='INPUT'"
          >
            <template v-slot:prepend>
              <q-icon name="cloud_upload" @click.stop.prevent />
            </template>
            <template v-slot:append>
              <q-icon
                name="close"
                @click.stop.prevent="file = null"
                class="cursor-pointer"
              />
            </template>
          </q-file>
        </q-card-section>

        <q-card-actions class="bg-white action-section">
          <q-btn color="primary" label="Save" @click="submitForm(task.id)" v-if="type==='INPUT'" />
          <q-btn
            class="text-primary"
            outlined
            flat
            label="Close"
            @click="closeDialog"
          />
        </q-card-actions>
      </q-card>
    </q-dialog>

    <q-dialog v-else-if="type === 'CONFIRM'" v-model="isOpen" persistent>
      <q-card class="dialog-card">
        <q-card-section class="bg-negative text-white title-section">
          <div class="text-h6 title-text">
            <q-icon name="warning" text-color="white" />
            {{ header }}
          </div>
        </q-card-section>
        <q-card-section class="row justify-center body-section">
          <span class="q-ml-sm">This action cannot be undone.</span>
        </q-card-section>

        <q-card-actions class="action-section">
          <q-btn
            class="text-negative"
            color="negative"
            label="Confirm"
            @click="deleteTask(task.id)"
          />
          <q-btn
            class="text-negative"
            flat
            color="negative"
            label="Cancel"
            @click="closeDialog"
          />
        </q-card-actions>
      </q-card>
    </q-dialog>
  </div>
</template>

<script>
import { defineComponent, ref } from "vue";
import { getInputValues } from "src/utils/functions/functions";
import { newTask, deleteTask, editTask } from "src/utils/functions/Tasks";
export default defineComponent({
  name: "DialogTemplate",
  props: {
    openDialog: {
      type: Boolean,
    },
    dialogTitle: {
      type: String,
    },
    dialogType: {
      type: String,
    },
    taskInfo:{
      type: Object,
    }
  },
  data() {
    this.initialState = {
      title: "",
      description: "",
      status: false,
      file: [{}],
    };
    return {
      isOpen: this.openDialog,
      header: this.dialogTitle,
      type: this.dialogType,
      task: this.taskInfo,
      ...this.initialState,
    };
  },
  methods: {
    closeDialog() {
      Object.assign(this, this.initialState);
      this.isOpen = false;
      this.$emit("closeDialog", this.isOpen);
    },
    async submitForm(id) {
      const formData = getInputValues(this);
      if(formData !== 0){
        if(id !== undefined){
          console.log(formData)
          const response = await editTask(formData, id)
          console.log(response)
        }else{
          const response = await newTask(formData);
          console.log(response)
        }
      }else{
        alert('Empty task cannot be recorded')
      }

    },
    async deleteTask(id){
      const response = await deleteTask(id)
      console.log(response)
    },
    isToggle(){
      if(this.task.status !== 'complete'){
        this.status = false
      }else{
        this.status = true
      }
    }
  },
  watch: {
    openDialog(newValue) {
      this.isOpen = newValue;
    },
    dialogTitle(newValue) {
      this.header = newValue;
    },
    dialogType(newValue) {
      this.type = newValue;
    },
    taskInfo(newValue){
      this.task = newValue
      this.title = newValue.title
      this.description = newValue.description
      this.status = newValue.status === 'complete'?true:false
      this.file = [{name: newValue.file_name}]
    }
  },
  computed: {
    required() {
      return (val) => !!val || "Title is required";
    },
    minLength() {
      return (val) =>
        val.length >= 3 || "Title should be a minimum of 3 characters";
    },
  },
});
</script>
