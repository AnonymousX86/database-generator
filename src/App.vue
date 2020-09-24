<template>
  <div id="app">
    <b-container :fluid="true" class="my-4">
      <MainForm />
    </b-container>
  </div>
</template>

<script>
import MainForm from '@/components/MainForm'
export default {
  name: 'App',
  components: { MainForm }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
</style>
