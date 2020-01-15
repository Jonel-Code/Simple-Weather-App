<template>
  <div>
    <div class="text-center">
      <div
        v-if="this.loading && city !== undefined"
        class="spinner-grow text-primary"
        role="status"
        style="width: 4em; height: 4em;"
        r
      >
        <span class="sr-only">Loading...</span>
      </div>
    </div>
    <div class="city_info_card" v-if="this.cityInfo && !this.loading">
      <h3>
        <b>{{this.cityInfo.display_name}}</b>
      </h3>
      <p>
        Longitude: {{this.cityInfo.longitude}}
        <br />
        Latitude: {{this.cityInfo.latitude}}
      </p>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      loading: true,
      cityInfo: undefined
    };
  },
  methods: {
    fetchCityInformation() {
      if (this.$props.city) {
        this.loading = true;
        axios
          .get(`/api/city/venue/${this.$props.city}`)
          .then(response => {
            this.cityInfo = response.data;
          })
          .catch(err => {
            console.error("fetchCityInformation", err);
          })
          .finally(() => {
            this.loading = false;
          });
      }
    }
  },
  props: ["city"],
  watch: {
    city() {
      this.fetchCityInformation();
    }
  }
};
</script>

<style lang="scss" scoped>
@import "../../sass/__variables.scss";
.city_info_card {
  font-size: $subFontSize;
}
</style>
