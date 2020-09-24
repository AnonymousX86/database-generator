<template>
  <b-row>
    <b-col
        xl="6" offset-xl="3"
        lg="8" offset-lg="2"
        md="10" offset-md="1"
        class="text-left bg-light p-4 rounded mx-4 mx-md-auto">
      <!--suppress HtmlUnknownTarget -->
      <form action="action.php" method="post" @submit="onSubmit" @reset.prevent="onReset">
        <b-row>
          <h1>Generator baz danych <a
              href="https://github.com/AnonymousX86/database-generator"
              target="_blank"
              rel="noopener"
              title="GitHub"
            ><b-icon icon="link45deg" class="h3"
            /></a></h1>
        </b-row>

        <b-row>
          <b-col cols="6">
            <label for="predefined">
              Ustawienia predefiniowane
            </label>
          </b-col>
          <b-col cols="6">
            <select name="predefined" id="predefined" v-model="options.scheme" required @change="updateValues">
              <option value="none" selected>Brak</option>
              <option value="pre-students-marks">Uczniowie i oceny</option>
            </select>
          </b-col>
        </b-row>

        <b-row>
          <b-col cols="6">
            <label for="db_rows">
              Liczba wierszy
            </label>
          </b-col>
          <b-col cols="6">
            <input
                type="range"
                name="db_rows"
                id="db_rows"
                v-model.number="options.db_rows"
                min="100"
                max="10000"
                step="100"
                required
            />
            <span>{{ options.db_rows }}</span>
          </b-col>
        </b-row>

        <b-row>
          <b-col cols="6">
            <label for="db_name">
              Nazwa bazy danych
            </label>
          </b-col>
          <b-col cols="6">
            <input
                type="text"
                id="db_name"
                name="db_name"
                minlength="3"
                maxlength="40"
                v-model="options.db_title"
                :readonly="selectedPredefined"
                required
            />
          </b-col>
        </b-row>

        <b-row>
          <b-col cols="6">
            <label for="db_tables_count">
              Liczba tabel
            </label>
          </b-col>
          <b-col cols="6">
            <input
                type="number"
                name="db_tables_count"
                id="db_tables_count"
                min="1"
                max="3"
                v-model.number="options.db_tables_count"
                :readonly="selectedPredefined"
                required
            />
          </b-col>
        </b-row>

        <b-row>
          <b-col cols="12">
            <b-alert v-for="(error, index) of errors" :key="index" variant="danger" :show="true" dismissible fade>
              {{ error }}
            </b-alert>
          </b-col>
          <b-col cols="6">
            <input id="submit" type="submit" class="btn btn-primary w-100" />
          </b-col>
          <b-col cols="6">
            <input id="reset" type="reset" class="btn btn-warning px-5 w-100" />
          </b-col>
        </b-row>

        <b-row class="border-bottom-0">
          Wykonane przez: Bartosz Roguś i Jakub Suchenek.
        </b-row>
      </form>
    </b-col>
    <b-col cols="12">
      <div id="result"></div>
    </b-col>
  </b-row>
</template>

<script>
export default {
  name: "MainForm",
  data() {
    return {
      options: this.defaultOptions(),
      predefined: {
        none: {
          db_title: '',
          db_tables_count: 1,
        },
        'pre-students-marks': {
          db_title: 'uczniowie_oceny',
          db_tables_count: 3,
        },
      },
      errors: [],
    }
  },
  computed: {
    selectedPredefined() {
      return this.options.scheme.startsWith('pre-')
    },
  },
  methods: {
    onSubmit(e) {
      const o = this.options
      this.errors = []
      if (o.db_title.length > 40 || o.db_title.length < 3)
        this.errors.push('Nazwa bazy danych powinna mieć od 3 do 40 znaków!')

      if (o.db_tables_count < 1 || o.db_tables_count > 3)
        this.errors.push('Liczba tabel powinna być z przedziału od 1 do 3!')

      if (!this.errors.length) return true

      e.preventDefault()
    },
    onReset() {
      this.options = this.defaultOptions()
    },
    predefinedValue(attribute) {
      return this.predefined[this.options.scheme][attribute]
    },
    updateValues() {
      let options = this.options
      options.db_title = this.predefinedValue('db_title')
      options.db_tables_count = this.predefinedValue('db_tables_count')
      this.options = options
    },
    defaultOptions() {
      return {
        scheme: 'none',
        db_rows: 5000,
        db_title: '',
        db_tables_count: 1,
      }
    },
  }
}
</script>

<style lang="scss" scoped>
label {
  display: block;
}
form {
  .row {
    border-bottom: solid gray 1px;
    margin: 10px 0;
    padding: 15px 0;
  }
}
</style>
