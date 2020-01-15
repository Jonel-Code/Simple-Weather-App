<template>
  <div
    class="card weather_card"
    :style="{
        'backgroundImage':
        `url('${this.weatherBg[weatherData.weatherType || 'clear']}')`
    }"
  >
    <div class="foreground" :class="{default:isDefaultLayout(), minified: !isDefaultLayout()}">
      <div class="temp">
        <p>
          {{weatherData.day}}
          <br />
          {{weatherData.description}}
          <br />
          <b>
            <span class="temp-text">{{weatherData.temperature}}&deg;C</span>
          </b>
        </p>
      </div>
      <div class="other" v-if="isDefaultLayout()">
        <p>
          Precipitation: {{weatherData.precipitation}}mm
          <sup>3</sup>
          <br />
          Humidity: {{weatherData.humidity}}%
        </p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    isDefaultLayout() {
      return this.$props.layout === "default";
    }
  },
  data() {
    return {
      weatherBg: {
        rain:
          "https://image.freepik.com/free-vector/rainfall-city-town-street-cartoon-vector_1441-3375.jpg",
        clear:
          "https://image.freepik.com/free-vector/sunny-landscape-spring-background_23-2148061225.jpg",
        clouds:
          "https://image.freepik.com/free-vector/sky-with-clouds-city-background-flat-style_23-2147797169.jpg",
        snow:
          "https://image.freepik.com/free-vector/winter-landscape-flat-design_23-2148341191.jpg"
      }
    };
  },
  props: {
    weatherData: { type: Object, default: {} },
    layout: { type: String, default: "default" }
  }
};
</script>

<style scoped lang="scss">
@import "../../sass/__variables.scss";

.weather_card {
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center;

  .foreground.minified {
    font-size: $subFontSize;
    background-color: #2d2c2ca2;
    .temp {
      .temp-text {
        font-size: $mainFontSize;
      }
    }
  }

  .foreground {
    color: #f1f1f1;
    background-color: #2d2c2c73;
    font-size: $mainFontSize;
    display: flex;
    padding: 1em 1em;
    flex-wrap: wrap;
    min-width: fit-content;
    div {
      flex: 1 1 auto;
    }
    .other {
      font-size: $subFontSize;
      display: flex;
      align-items: flex-end;
    }
    .temp {
      .temp-text {
        font-size: $titleFontSize;
      }
    }
  }
}
</style>
