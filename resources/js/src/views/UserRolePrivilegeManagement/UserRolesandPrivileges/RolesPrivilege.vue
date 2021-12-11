<template>
  <div class="container pt-3 pb-5">
    <h2>TABLE</h2>
    <b-table striped hover :items="posts"></b-table>
  </div>
</template>

<script>
export default {
  props: ["posts"]
}
</script>