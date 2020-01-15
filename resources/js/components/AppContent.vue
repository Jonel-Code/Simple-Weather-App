<template>
  <div class="main container-fluid" v-if="!this.appLoading">
    <!-- City Selection -->
    <div class="mx-auto container-fluid" id="search_form">
      <label for="city">Select a city: &nbsp;</label>
      <DropDown
        ref="dropdown"
        class="dd_search"
        name="city"
        placeholder="Select a City"
        :options="this.availableCities"
        :maxItem="10"
        @selected="this.selectCity"
      />
    </div>
    <!-- City Information -->
    <div class="container-fluid city_info">
      <CityInformationCard :city="this.selectedCity" />
    </div>
    <!-- Weather Forecast -->
    <div class="city_weather_cards container-fluid">
      <h4>
        <span v-if="this.selectedCity">Daily Weather Forecast:</span>
      </h4>
      <CityWeatherCard v-if="selectedCity" :city="this.selectedCity" />
    </div>
  </div>
</template>

<script>
import DropDown from "vue-simple-search-dropdown";
import axios from "axios";
import CityWeatherCard from "./CityWeatherCard";
import CityInformationCard from "./CityInformationCard";
export default {
  methods: {
    selectCity(event) {
      /**
       * @scope Dropdown Bug fix
       * @bug upon clicking the first item on the selection without search value
       * it will not display the selected value
       * but still emits the selected value on first event
       * then undefined on the second see on console
       * @fix save and use the previous selected option then manually set
       * the selection by referencing and calling the selectOption() method of the component
       * @note removing this scope the bug cause the bug
       */
      {
        if (
          event.name === undefined &&
          this.prevSelectedOption !== undefined &&
          this.prevSelectedOption.id !== undefined &&
          this.prevSelectedOption.name !== undefined &&
          this.$refs.dropdown !== undefined
        ) {
          this.$refs.dropdown.selectOption(this.prevSelectedOption);
        }
        this.prevSelectedOption = event;
      }

      //   avoid undefined selection
      if (event.name !== undefined) {
        this.selectedCity = event.name;
      }

      console.log("selectCity event", { name: event.name, id: event.id });
    },
    fetchCityListing() {
      this.appLoading = true;
      axios
        .get("/api/city/list")
        .then(response => {
          this.availableCities = response.data.map((city, i) => ({
            id: i,
            name: city
          }));
          console.log("this.availableCities ", this.availableCities);
        })
        .catch(error => {
          console.error(error);
        })
        .finally(() => {
          this.appLoading = false;
        });
    }
  },
  data() {
    return {
      appLoading: true,
      selectedCity: undefined,
      availableCities: [],
      prevSelectedOption: undefined
    };
  },
  beforeMount() {
    this.fetchCityListing();
  },
  components: {
    CityWeatherCard,
    DropDown,
    CityInformationCard
  }
};
</script>

<style lang="scss">
@import "../../sass/__variables.scss";

#search_form {
  display: flex;
  width: 70%;
  font-size: $mainFontSize !important;
  width: fit-content;
  flex-wrap: wrap;
  margin-bottom: 1em;
  label {
    margin: 0px;
    display: flex;
    align-items: center;
  }
  .dd_search {
    font-family: "Roboto", sans-serif !important;
    flex: 1 auto;
  }
}
</style>
