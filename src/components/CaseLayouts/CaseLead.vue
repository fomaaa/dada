<template>
  <div class="case-text-content Lead" v-html="leadText"></div>
</template>

<script>
  export default {
    name: "CaseLead",
    props: ['leadText']
  }
</script>
