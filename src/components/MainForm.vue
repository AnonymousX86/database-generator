<template>
  <b-row>
    <b-col
      xl="6"
      offset-xl="3"
      lg="8"
      offset-lg="2"
      md="10"
      offset-md="1"
      class="text-left bg-light p-4 rounded mx-1 mx-md-auto"
    >
      <header>
        <b-row class="my-0">
          <h1>
            Generator baz danych
            <a
              href="https://github.com/AnonymousX86/database-generator"
              target="_blank"
              rel="noopener"
              title="GitHub"
              class="d-none d-sm-inline"
            >
              <b-icon icon="link45deg" class="h3" />
            </a>
          </h1>
        </b-row>
      </header>

      <main>
        <!--suppress HtmlUnknownTarget -->
        <form
          action="action.php"
          method="post"
          @submit="onSubmit"
          @reset.prevent="onReset"
        >
          <!-- Predefined -->
          <b-row class="text-center text-sm-left">
            <b-col sm="6">
              <label for="predefined">Ustawienia predefiniowane</label>
            </b-col>
            <b-col sm="6">
              <select
                name="predefined"
                id="predefined"
                v-model="options.scheme"
                required
                @change="updateValues"
              >
                <option value="none" selected>Brak</option>
                <option value="pre-students-marks">Uczniowie i oceny</option>
              </select>
            </b-col>
          </b-row>

          <!-- Rows count -->
          <b-row class="text-center text-sm-left">
            <b-col sm="6">
              <label for="db_rows">Liczba wierszy</label>
            </b-col>
            <b-col sm="6">
              <input
                type="range"
                name="db_rows"
                id="db_rows"
                v-model.number="options.db_rows"
                :min="limits.db_rows.min"
                :max="limits.db_rows.max"
                step="100"
                required
              />
              <span class="d-inline-block ml-2">{{ options.db_rows }}</span>
            </b-col>
          </b-row>

          <!-- Database name -->
          <b-row class="text-center text-sm-left">
            <b-col sm="6">
              <label for="db_name">Nazwa bazy danych</label>
            </b-col>
            <b-col sm="6">
              <input
                type="text"
                id="db_name"
                name="db_name"
                :minlength="limits.db_name.minlength"
                :maxlength="limits.db_name.maxlength"
                v-model="options.db_name"
                :readonly="selectedPredefined"
                required
              />
            </b-col>
          </b-row>

          <!-- Tables count -->
          <b-row class="text-center text-sm-left">
            <b-col sm="6">
              <label for="db_tables_count">Liczba tabel</label>
            </b-col>
            <b-col sm="6">
              <input
                type="number"
                name="db_tables_count"
                id="db_tables_count"
                :min="limits.db_tables_count.min"
                :max="limits.db_tables_count.max"
                v-model.number="options.db_tables_count"
                :readonly="selectedPredefined"
                required
              />
            </b-col>
          </b-row>

          <!-- X table's scheme -->
          <transition-group tag="div">
            <b-row v-for="index in this.options.db_tables_count" :key="index">
              <b-col cols="12">
                <h2>Szablon {{ index }}. tabeli</h2>
                <details open>
                  <summary>Opcje</summary>
                  <!-- Title -->
                  <b-row class="text-center text-sm-left">
                    <b-col sm="6">
                      <label :for="'tables[' + (index - 1) + '][title]'"
                        >Tytuł</label
                      >
                    </b-col>
                    <b-col sm="6">
                      <!--suppress HtmlFormInputWithoutLabel -->
                      <input
                        :id="'tables[' + (index - 1) + '][title]'"
                        :name="'tables[' + (index - 1) + '][title]'"
                        v-model="options.db_tables[index - 1].title"
                        type="text"
                        :minlength="limits.db_tables_title.minlength"
                        :maxlength="limits.db_tables_title.maxlength"
                        required
                      />
                    </b-col>
                  </b-row>

                  <!-- Columns count and types -->
                  <b-row class="text-center text-sm-left">
                    <b-col sm="6">
                      <label :for="'tables[' + (index - 1) + '][cols_count]'"
                        >Liczba kolumn</label
                      >
                    </b-col>
                    <b-col sm="6">
                      <!--suppress HtmlFormInputWithoutLabel -->
                      <input
                        :id="'tables[' + (index - 1) + '][cols_count]'"
                        type="number"
                        v-model.number="options.db_tables[index - 1].cols_count"
                        :min="limits.db_tables_cols_count.min"
                        :max="limits.db_tables_cols_count.max"
                        required
                      />
                    </b-col>
                    <b-col cols="12">
                      <transition-group tag="div">
                        <div
                          v-for="i in options.db_tables[index - 1].cols_count"
                          :key="i"
                          class="text-center text-sm-left"
                        >
                          <b-row>
                            <b-col sm="6">
                              <label
                                :for="
                                  'tables[' +
                                    (index - 1) +
                                    '][' +
                                    (i - 1) +
                                    '][type]'
                                "
                                >{{ i }}. Typ danych</label
                              >
                            </b-col>
                            <b-col sm="6">
                              <!--suppress HtmlFormInputWithoutLabel -->
                              <select
                                :name="
                                  'tables[' +
                                    (index - 1) +
                                    '][' +
                                    (i - 1) +
                                    '][scheme]'
                                "
                                :id="
                                  'tables[' +
                                    (index - 1) +
                                    '][' +
                                    (i - 1) +
                                    '][scheme]'
                                "
                                v-model="
                                  options.db_tables[index - 1].cols[i - 1]
                                    .scheme
                                "
                                required
                              >
                                <option v-if="i === 1" value="id">ID</option>
                                <option
                                  v-for="(column, index) of columnsSchemes"
                                  :key="index"
                                  :value="column.id"
                                >
                                  {{ column.hid }}
                                </option>
                              </select>
                              <label class="mt-1">
                                <input
                                  type="text"
                                  v-model="
                                    options.db_tables[index - 1].cols[i - 1]
                                      .title
                                  "
                                />
                              </label>
                            </b-col>
                          </b-row>
                        </div>
                      </transition-group>
                    </b-col>
                  </b-row>
                </details>
              </b-col>
            </b-row>
          </transition-group>

          <!-- Alerts + buttons -->
          <b-row>
            <b-col cols="12" class="mb-3">
              <b-alert
                v-for="(error, index) of errors"
                :key="index"
                variant="danger"
                :show="true"
                dismissible
                fade
              >
                {{ error }}
              </b-alert>
            </b-col>
            <b-col md="6" class="mb-3">
              <input
                id="submit"
                type="submit"
                class="btn btn-primary py-2 w-100"
              />
            </b-col>
            <b-col md="6">
              <input
                id="reset"
                type="reset"
                class="btn btn-warning py-2 w-100"
              />
            </b-col>
          </b-row>
        </form>
      </main>

      <footer>
        <b-row class="border-bottom-0">
          <b-col class="text-center">
            Wykonane przez uczniów
            <strong class="pr-1">Bartosz&nbsp;Roguś</strong
            >i&nbsp;<strong>Jakub&nbsp;Suchenek</strong>.
          </b-col>
        </b-row>
      </footer>
    </b-col>
  </b-row>
</template>

<script>
export default {
  name: 'MainForm',
  data() {
    return {
      options: this.defaultOptions(),
      errors: []
    }
  },
  computed: {
    selectedPredefined() {
      return this.options.scheme.startsWith('pre-')
    },
    predefined() {
      return {
        none: this.defaultOptions,
        'pre-students-marks': {
          db_name: 'uczniowie_oceny',
          db_tables_count: 3
        }
      }
    },
    limits() {
      return {
        db_rows: {
          min: 100,
          max: 10000
        },
        db_name: {
          minlength: 3,
          maxlength: 40
        },
        db_tables_count: {
          min: 1,
          max: 3
        },
        db_tables_title: {
          minlength: 3,
          maxlength: 40
        },
        db_tables_cols_count: {
          min: 2,
          max: 4
        }
      }
    },
    columnsSchemes() {
      return [
        {
          id: 'name',
          hid: 'Imię'
        },
        {
          id: 'surname',
          hid: 'Nazwisko'
        },
        {
          id: 'gender',
          hid: 'Płeć'
        },
        {
          id: 'pesel',
          hid: 'PESEL'
        },
        {
          id: 'class',
          hid: 'Klasa'
        },
        {
          id: 'birthday',
          hid: 'Data urodzenia'
        }
      ]
    }
  },
  methods: {
    onSubmit(form) {
      const o = this.options
      const l = this.limits
      this.errors = []

      if (o.db_rows < l.db_rows.min || o.db_rows > l.db_rows.max)
        this.addError(
          'Liczba wierszy powinna być z przedziału od ' +
            l.db_rows.min +
            ' do ' +
            l.db_rows.max +
            '!'
        )

      if (
        o.db_name.length < l.db_name.minlength ||
        o.db_name.length > l.db_name.maxlength
      )
        this.addError(
          'Nazwa bazy danych powinna mieć od ' +
            l.db_name.minlength +
            ' do ' +
            l.db_name.maxlength +
            ' znaków!'
        )

      if (
        o.db_tables_count < o.db_tables_count.min ||
        o.db_tables_count > o.db_tables_count.max
      )
        this.addError(
          'Liczba tabel powinna być z przedziału od ' +
            o.db_tables_count.min +
            ' do ' +
            o.db_tables_count.max +
            '!'
        )

      for (let i = 0; i < o.db_tables_count; i++) {
        if (
          o.db_tables[i].title.length < l.db_tables_title.minlength ||
          o.db_tables[i].title.length > l.db_tables_title.maxlength
        ) {
          this.addError(
            'Długość ' +
              (i + 1) +
              ' nazwy tabeli powinna być z przedziału od ' +
              l.db_tables_title.minlength +
              ' do ' +
              l.db_tables_title.maxlength +
              '!'
          )
          break
        }
        /*
        Both if statements should be checked,
        but it will be more complicated than necessary.
        */
        if (
          o.db_tables[i].cols_count < l.db_tables_cols_count.min ||
          o.db_tables[i].cols_count > l.db_tables_cols_count.max
        ) {
          this.addError(
            'Ilość kolumn w tabeli powinna być z przedziału od ' +
              l.db_tables_cols_count.min +
              ' do ' +
              l.db_tables_cols_count.max +
              '!'
          )
          break
        }
      }

      if (!this.errors.length) return true

      form.preventDefault()
    },
    onReset() {
      this.options = this.defaultOptions
    },
    predefinedValue(attribute) {
      return this.predefined[this.options.scheme][attribute]
    },
    updateValues() {
      let options = this.options
      options.db_name = this.predefinedValue('db_name')
      options.db_tables_count = this.predefinedValue('db_tables_count')
      this.options = options
    },
    defaultOptions() {
      const data = {
        scheme: 'none',
        db_rows: 5000,
        db_name: '',
        db_tables_count: 1,
        db_tables: []
      }
      for (let i = 0; i < 3; i++) {
        const n_data = {
          title: '',
          cols_count: 2,
          cols: []
        }
        for (let j = 0; j < 4; j++)
          n_data.cols.push({
            scheme: j === 0 ? 'id' : '',
            title: ''
          })
        data.db_tables.push(n_data)
      }
      return data
    },
    addError(text = null) {
      this.errors.push(text || 'Wystąpił nieokreślony błąd!')
    }
  }
}
</script>

<style lang="scss" scoped>
h1,
h2 {
  width: 100%;
  border-bottom: solid #b0b0b0 1px;
  padding-bottom: 5px;
  margin-bottom: 10px;
}

label {
  display: block;
}

.row {
  //border-bottom: solid gray 1px;
  margin: 10px 0;
  padding: 15px 0;
}

details[open] summary ~ * {
  animation: sweep 0.5s ease-in-out;
}

@keyframes sweep {
  0% {
    opacity: 0;
    margin-left: 100px;
  }
  100% {
    opacity: 1;
    margin-left: 0;
  }
}

strong {
  display: inline-block;
  margin: 0;
}

.v-enter-active,
.v-leave-active {
  transition: all 0.5s ease-in-out;
}

.v-enter,
.v-leave-to {
  opacity: 0;
}
</style>
