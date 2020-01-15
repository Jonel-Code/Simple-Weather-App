<template>
  <div class="content">
    <div class="header">
      <AppHeader />
    </div>
    <div class="main">
      <AppContent class="container-fluid" />
    </div>
    <div class="footer">
      <AppFooter />
    </div>
  </div>
</template>

<script>
import AppHeader from "./AppHeader";
import AppContent from "./AppContent";
import AppFooter from "./AppFooter";

export default {
  components: {
    AppHeader,
    AppContent,
    AppFooter
  }
};
</script>

<style lang="scss" scoped>
@import "../../sass/__variables.scss";

.content {
  font-family: "Roboto", sans-serif;
  min-height: 100vh;
  padding-top: 2em;
  display: flex;
  flex-direction: column;
  .header {
    text-align: center;
  }
  .main {
    flex: 1 auto;
    background-color: #f1f1f1;
  }
  .footer {
    margin-top: 1em;
    text-align: center;
  }
}
</style>
