<template>
  <div>
    <form action="" @submit.prevent="generateChart">
      <div class="row">
        <div class="col-3">
          <div class="form-group row">
            <label for="inputEmail3" class="col-sm-3 col-form-label">Type</label>
            <div class="col-sm-9">
              <select name="pets" id="pet-select">
                  <option value="">--Please choose an option--</option>
                  <option value="dog">Dog</option>
                  <option value="cat">Cat</option>
                  <option value="hamster">Hamster</option>
                  <option value="parrot">Parrot</option>
                  <option value="spider">Spider</option>
                  <option value="goldfish">Goldfish</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label for="inputEmail3" class="col-sm-3 col-form-label">Group by</label>
            <div class="col-sm-9">
              <input-component v-model="groupBy"
                :type="'dropdown'"
                css-class="form-control"
                :relationDisplay="'label'"
                :options="groups"
              />
            </div>
          </div>
          <div class="form-group row">
            <label for="inputEmail3" class="col-sm-3 col-form-label">From</label>
            <div class="col-sm-9">
              <input-component v-model="from"
                :type="'date'"
                css-class="form-control"
              />
            </div>
          </div>
          <div class="form-group row">
            <label for="inputEmail3" class="col-sm-3 col-form-label">To</label>
            <div class="col-sm-9">
              <input-component v-model="to"
                :type="'date'"
                css-class="form-control"
              />
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Generate Chart</button>
        </div>
        <div class="col-3" v-if="filters">
          <h4 class="mb-4 d-block">Filters</h4>
          <div class="form-group row" v-for="filter in filters" :key="filter.property">
            <label for="inputEmail3" class="col-sm-3 col-form-label">{{ filter.label }}</label>
            <div class="col-sm-9">
              <input-component v-model="filtersData[filter.property]"
                :type="filter.type"
                css-class="form-control"
                :relation="filter.relation"
                :relationDisplay="filter.relationDisplay"
              />
            </div>
          </div>
        </div>
      </div>
    </form>
    <chart-component
      :type="type"
      :data="data"
      :options="options"
    />
  </div>
</template>

<script>
  export default {
    props: {
      apiEndpoint: String,
      filters: null,
      groups: null,
    },
    data: () => ({
      type: 'bar',
      rawData: null,
      groupBy: null,
      filtersData: {},
      from: null,
      to: null,
      data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            borderWidth: 1
        }],
        options: {
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero: true
                  }
              }]
          }
        }
        },
    }),
    computed: {
      apiRoute () {
        return `/api/${this.apiEndpoint}`
      },
    },
    methods: {
      async fetchData () {
        const response = await axios.get(`${this.apiRoute}/report`, {
          headers: {
              from: this.from ? this.from : '',
              to: this.to ? this.to : '',
          }
        })
        this.rawData = response.data
      },
      formatData () {
        console.log(Object.keys(this.filtersData))
        const filteredData = this.rawData.filter(data => {
          return Object.keys(this.filtersData).reduce((pass, filter) => {
            if (this.filtersData[filter] == null) return false
            console.log(filter, this.filtersData[filter])
            return pass
              ? data[filter].id == this.filtersData[filter].id
              : false
          }, true)
        })
        const groupedData = _.groupBy(filteredData, `${this.groupBy.property}.id`)
        this.data.labels = []
        this.data.datasets = [{
          label: this.groupBy.label,
          data: [],
          borderWidth: 1,
        }]
        Object.keys(groupedData).forEach(group => {
          this.data.labels.push(_.head(groupedData[group])[this.groupBy.relationDisplay])
          _.head(this.data.datasets).data.push(groupedData[group].length)
        });
        this.data = _.clone(this.data)
        console.log(this.rawData, filteredData, groupedData)
      },
      async generateChart() {
        await this.fetchData()
        this.formatData()
      }
    },
  }
</script>
