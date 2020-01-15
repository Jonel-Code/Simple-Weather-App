<template>
  <div class="container-fluid" id="date_text">
    <p>{{this.formattedCurrentDate}}</p>
  </div>
</template>

<script>
import dateFormatter from "../util/dateFormatter";
export default {
  data() {
    return {
      formattedCurrentDate: dateFormatter.getFormattedCurrentDate()
    };
  }
};
</script>

<style>
</style>
