<template>
  <div class="city_card">
    <div class="text-center">
      <div
        v-if="isLoading"
        class="spinner-grow text-primary"
        role="status"
        style="width: 4em; height: 4em;"
        r
      >
        <span class="sr-only">Loading...</span>
      </div>
    </div>
    <div class="main" v-if="!isLoading">
      <WeatherCard
        class="material_card"
        v-if="this.getNormalizedCurrentDayWeather"
        :layout="'default'"
        :weatherData="this.getNormalizedCurrentDayWeather"
      />

      <div class="d-flex flex-wrap justify-content-center weather_calendar">
        <div v-for="(weather, i) in this.normalizeWeatherList" :key="i">
          <WeatherCard
            class="item material_card"
            v-if="i !==0"
            :layout="'minified'"
            :weatherData="weather"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import WeatherCard from "./WeatherCard";
import dateFormatter from "../util/dateFormatter";

export default {
  methods: {
    mapWeather(weather) {
      return {
        weatherType: (weather.type || "").toLowerCase(),
        temperature: weather.temp_ave,
        description: weather.description,
        day: dateFormatter.getWeekDayFromDate(
          dateFormatter.formatUnixDate(Number(weather.forcast_date))
        ),
        precipitation: weather.precipitation,
        humidity: weather.humidity
      };
    },
    fetchForecast() {
      this.isLoading = true;
      return axios
        .get(`/api/forecast/${this.$props.city}`)
        .then(response => {
          this.forecasts = response.data.dates || [];
        })
        .catch(err => {
          console.log(
            "%cError in Fetching Forecast!",
            "color:red;font-size:30px"
          );
          console.error(err);
          this.forecasts = [];
        })
        .finally(() => {
          this.isLoading = false;
        });
    }
  },
  computed: {
    normalizeWeatherList() {
      return this.forecasts.map(this.mapWeather);
    },
    getNormalizedCurrentDayWeather() {
      return this.forecasts[0] ? this.mapWeather(this.forecasts[0]) : undefined;
    }
  },
  data() {
    return {
      forecasts: [],
      isLoading: true
    };
  },
  props: {
    city: {
      type: String,
      default: undefined
    }
  },
  beforeMount() {
    this.fetchForecast();
  },
  watch: {
    city() {
      this.fetchForecast();
    }
  },
  components: {
    WeatherCard
  }
};
</script>

<style lang="scss">
@import "../../sass/__variables.scss";
.main {
  .weather_calendar {
    margin-top: 1rem;
    width: 100%;
    .item {
      width: 192px;
      margin: 5px 5px;
    }
  }

  .material_card {
    @include material_card;
  }
}
</style>
