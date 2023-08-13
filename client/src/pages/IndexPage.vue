<template>
  <q-page class="flex flex-center fluid">
    <ContentTable />
  </q-page>
</template>

<script>
import { defineComponent, ref } from "vue";
import ContentTable from "src/components/ContentTable.vue";
export default defineComponent({
  name: "IndexPage",
  components: {
    ContentTable,
  },
});
</script>
