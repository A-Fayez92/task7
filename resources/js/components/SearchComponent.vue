<template>
  <div class="container">
    <div class="row justify-content-center">
      <table class="table">
        <thead class="table-dark">
          <tr>
            <th scope="col">Filter By</th>
            <th scope="col">Comp</th>
            <th scope="col">Value</th>
            <th scope="col">Rel</th>
          </tr>
        </thead>
        <tbody v-for="n in repeate" :key="n">
          <tr>
            <th scope="row">
              <select
                class="form-select"
                aria-label="Default select example"
                v-model="queries[n-1].fil"
              >
                <option selected value>Filter By</option>
                <option value="name">Name</option>
                <option value="gender">Gender</option>
                <option value="age">Age</option>
                <option value="country">Country</option>
                <option value="posts">Posts</option>
              </select>
            </th>
            <td>
              <select
                class="form-select"
                aria-label="Default select example"
                v-model="queries[n-1].comp"
              >
                <option selected value>Comparison</option>
                <option value="=">Equals</option>
                <option value="!=">Not Equal</option>
                <option value=">">Greater Than</option>
                <option value=">=">Greater Than or Equal</option>
                <option value="<">Less Than</option>
                <option value="<=">Less Than or Equal</option>
                <option value="contains">Contains</option>
                <option value="startWith">Start With</option>
                <option value="endWith">End With</option>
              </select>
            </td>
            <td>
              <input
                type="text"
                class="form-control"
                placeholder="Value"
                v-model="queries[n-1].val"
              />
            </td>
            <td>
              <select
                class="form-select"
                aria-label="Default select example"
                v-model="queries[n-1].rel"
                @change="pushQuery()"
              >
                <option selected value>Relation</option>
                <option value="and">AND</option>
                <option value="or">OR</option>
              </select>
            </td>
          </tr>
        </tbody>
      </table>

      <input
        type="button"
        class="form-control bg-primary"
        value="Get Data"
        @click.prevent="getUsers()"
      />
      <table class="table">
        <thead class="thead-light">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Gender</th>
            <th scope="col">Age</th>
            <th scope="col">Country</th>
            <th scope="col">Posts</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(user,index) in users.data" :key="user.id">
            <th scope="row">{{(users.meta.current_page*5)-5 + index+1}}</th>
            <td>{{user.name}}</td>
            <td>{{user.gender}}</td>
            <td>{{user.age}}</td>
            <td>{{user.country}}</td>
            <td>{{user.posts}}</td>
          </tr>
        </tbody>
      </table>
      <pagination :data="users" :limit="5" @pagination-change-page="getResults">
        <span slot="prev-nav">&lt; Previous</span>
        <span slot="next-nav">Next &gt;</span>
      </pagination>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      qs: require("qs"),
      repeate: 1,
      users: {},
      queries: [{ fil: "", comp: "", val: "", rel: "" }],
    };
  },
  methods: {
    getUsers() {
      axios
        .get("/getUsers", {
          params: {
            queries: this.queries,
          },
          paramsSerializer: (params) => {
            return this.qs.stringify(params);
          },
        })
        .then((res) => {
          this.users = res.data;
        });
    },
    pushQuery() {
      var query = this.queries[this.repeate - 1];
      if (
        query.fil != "" &&
        query.comp != "" &&
        query.val != "" &&
        query.rel != ""
      ) {
        this.repeate++;

        this.queries.push({
          fil: "",
          comp: "",
          val: "",
          rel: "",
        });
      }
    },
    getResults(page = 1) {
      axios
        .get("/getUsers?page=" + page, {
          params: {
            queries: this.queries,
          },
          paramsSerializer: (params) => {
            return this.qs.stringify(params);
          },
        })
        .then((response) => {
          this.users = response.data;
        });
    },
  },
  created() {},
};
</script>
