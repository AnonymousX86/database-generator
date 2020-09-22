<template>
  <div>
    <!--suppress HtmlUnknownTarget -->
    <form action="action.php" method="post" @submit.prevent="onSubmit">
      <p>
        <label for="predefined">
          Ustawienia predefiniowane
          <select name="predefined" id="predefined" v-model="options.scheme">
            <option value="pre-students-marks">Uczniowie i oceny</option>
            <option value="custom" disabled>Ustawienia własne</option>
          </select>
        </label>

        <label>
          Liczba wierszy
          <input
              type="range"
              name="db_rows"
              id="db_rows"
              v-model="options.db_rows"
              value="500"
              min="10"
              max="10000"
              step="100"
          />
          <span>{{ options.db_rows }}</span>
        </label>

        <label>
          Nazwa bazy danych
          <input
              type="text"
              :value="predefinedValue('title')"
              :disabled="selectedPredefined"
          />
        </label>

        <label for="tables-count">
          Liczba tabel
          <input
              type="number"
              name="tables-count"
              id="tables-count"
              min="2"
              max="8"
              :value="predefinedValue('title')"
              :disabled="selectedPredefined"
          />
        </label>
      </p>
      <p>
        <input id="submit" type="submit" />
      </p>
    </form>
    <div id="result"></div>
  </div>
</template>

<script>
export default {
  name: "MainForm",
  data() {
    return {
      options: {
        scheme: '',
        db_title: '',
        db_rows: 10,
      },
      predefined: {
        'pre-students-marks': {
          db_title: 'uczniowie_oceny',
        }
      }
    }
  },
  computed: {
    selectedPredefined() {
      return this.options.scheme.startsWith('pre-')
    }
  },
  methods: {
    onSubmit() {},
    predefinedValue(attribute) {
      return this.selectedPredefined ? this.predefined[this.options.scheme][attribute] : ''
    }
  }
}
</script>

<style scoped>
label {
  display: block;
  margin-bottom: 15px;
}
</style>