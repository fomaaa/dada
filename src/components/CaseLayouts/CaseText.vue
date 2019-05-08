<template>
  <div class="case-text-content Text" v-html="textText"></div>
</template>

<script>
  export default {
    name: "CaseText",
    props: ['textText']
  }
</script>
