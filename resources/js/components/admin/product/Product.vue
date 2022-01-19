<template>
  <div>
    <admin-main></admin-main>
    <div class="content-wrapper">
      <section class="content-header">
        <h1>
          <router-link :to="{ name: 'productAdd' }" class="btn btn-primary">
            <i class="fa fa-plus"></i>
          </router-link>

          <strong>Product'table</strong>
        </h1>
        <ol class="breadcrumb">
          <li>
            <a href="#"> <i class="fa fa-dashboard"></i>Dashboard </a>
          </li>
          <li class="active">Product Table</li>
        </ol>
      </section>
      <section class="content">
        <div class="container">
          <div class="row">
            <div class="col-lg-11 col-md-11">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <div class="row">
                    <div class="col-lg-2">
                       <button @click="showModal" class="btn btn-success btn-sm"> Product Bulk Print  </button>
                    </div>
                    <div class="col-lg-2"></div>
                    <div class="col-lg-4">
                      <input
                        class="form-control"
                        placeholder="search with product code || product name "
                        v-model="search"
                        @keyup="searchProducts()"
                      />
                    </div>
                    <div class="col-lg-2">
                      <select
                        class="form-control"
                        v-model="item"
                        @change="productList()"
                      >
                        <option value="30">30</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="150">150</option>
                        <option value="200">200</option>
                      </select>
                    </div>
                    <div class="col-lg-2">
                      <select
                        class="form-control"
                        v-model="status"
                        @change="productList"
                      >
                        <option value="all">All</option>
                        <option value="1">Approved</option>
                        <option value="2">Pending</option>
                        <option value="3">Deny</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="box-body">
                  <table
                    class="
                      table
                      text-center
                      table-striped table-hover table-bordered
                    "
                  >
                    <thead>
                      <tr>
                        <th width="5%">
                          <input type="checkbox" @click="selectAll" />
                        </th>
                        <th width="10%">name</th>
                        <th width="10%">barcode</th>
                        <th width="5%">image</th>
                        <th width="5%">purchase price</th>
                        <th width="5%">price</th>
                        <th width="5%">discount</th>
                        <th width="5%">sale price</th>
                        <th width="5%">stock</th>
                        <th width="5%">status</th>
                        <th width="10%">action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <h1 class="text-center" v-if="loading">
                        <i class="fa fa-spin fa-spinner"></i>
                      </h1>

                      <tr v-for="(product, index) in products.data" v-else>
                        <td style="width: 1%">
                          <input
                            type="checkbox"
                            class="select-all"
                            v-model="form.products_id"
                            :value="product.id"
                          />
                        </td>
                        <td>{{ product.name }}</td>
                        <td style="width: 100px">
                          <p
                            v-html="product.product_barcode.barcode"
                            class="barcode"
                          ></p>
                          <span>{{
                            product.product_barcode.barcode_number
                          }}</span>
                        </td>
                        <td>
                          <img
                            :src="thumbnail_img_url + product.thumbnail_img"
                            class="table-image product_img"
                            alt="product image"
                          />
                        </td>
                        <td>{{ purchasePrice(product.purchase_item) }}</td>
                        <td>{{ product.sale_price }}</td>
                        <td>
                          <span class="badge badge-warning">{{
                            product.discount ? product.discount : "0"
                          }}</span>
                        </td>
                        <td>{{ product.price }}</td>

                        <td>
                          <span
                            v-if="product.stock <= 5"
                            class="badge badge-danger"
                            >{{ product.stock }}</span
                          >
                          <span v-else class="badge badge-success">{{
                            product.stock
                          }}</span>
                        </td>

                        <td>
                          <span
                            class="badge badge-success"
                            v-if="product.status == 1"
                            >Approved</span
                          >
                          <span
                            class="badge badge-primary"
                            v-else-if="product.status == 2"
                            >Pending</span
                          >
                          <span class="badge badge-warning" v-else>Deny</span>
                          <br />
                          <span
                            style="min-width: 70px"
                            class="badge badge-success"
                            v-if="product.show_home_page == 1"
                          >
                            Publish
                          </span>
                          <span class="badge badge-warning" v-else>
                            Unpublish
                          </span>
                        </td>

                        <td>
                          <i
                            class="fa fa-bars"
                            @click="changeDisplay(product)"
                          ></i>

                          <div class="dropdown-action" :id="product.id">
                            <a
                              class="
                                dropdown-item
                                btn btn-success btn-sm
                                dropbtn
                              "
                              v-if="product.status != 1"
                              @click="approved(product)"
                              >Approved</a
                            >

                            <a
                              class="
                                dropdown-item
                                btn btn-primary btn-sm
                                dropbtn
                              "
                              v-if="product.status != 2"
                              @click="pending(product)"
                              >Pending</a
                            >
                            <a
                              class="
                                dropdown-item
                                btn btn-warning btn-sm
                                dropbtn
                              "
                              v-if="product.status != 3"
                              @click="deny(product)"
                              >Deny</a
                            >

                            <a
                              class="dropdown-item btn btn-info btn-sm dropbtn"
                              @click="copy(product.id)"
                              >Copy</a
                            >

                            <a
                              class="
                                dropdown-item
                                btn btn-warning btn-sm
                                dropbtn
                              "
                              @click.print="print(product.id)"
                              >Print</a
                            >

                            <router-link
                              :to="{
                                name: 'productEdit',
                                params: { id: product.id },
                              }"
                              class="btn btn-success btn-sm dropbtn"
                              >Edit</router-link
                            >
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="box-footer">
                  <div class="row">
                    <div class="col-lg-6">
                      <pagination
                        :data="products"
                        @pagination-change-page="productList"
                        :limit="3"
                      ></pagination>
                    </div>
                    <div
                      class="col-lg-6 mt-1"
                      style="margin-top: 25px; text-align: right"
                    >
                      <p>
                        Showing
                        <strong>{{ products.from }}</strong> to
                        <strong>{{ products.to }}</strong> of total
                        <strong>{{ products.total }}</strong> entries
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  <!-- start pdf download modal  -->
         <modal name="product_bulk_modal" :width="400" :height="300">
           <form @submit.prevent="previewBulkPrint" method="post" >
              <div class="card" style="padding: 20px">
                 <div class="card-header text-center">
                </div>
              <div class="card-body">
                  <div class="form-group">
                    <label>Start Date</label>
                    <date-picker
                      autocomplete="off"
                      v-model="form.start_date"
                      name="start_date"
                      :config="options"
                      required
                    ></date-picker>
                  </div>

                 <div class="form-group">
                    <label>End Date</label>
                    <date-picker
                      autocomplete="off"
                      v-model="form.end_date"
                      name="end_date"
                      required
                      :config="options"
                    ></date-picker>
                  </div>


                <br>
                <div class="form-group text-center">

                   <button  type="submit"
                    class="btn btn-success ">
                      Submit
                  </button>

                </div>
                <br>
              </div>
            </div>
           </form>
          </modal>
   <!-- end pdf download modal  -->

  </div>
</template>

<script>
import { Form, HasError, AlertError } from "vform";
export default {
  created() {
    this.productList();
    setTimeout(() => {
      this.loading = false;
    }, 500);
  },
  data() {
    return {
      products: {},
      loading: true,
      search: "",
      item: 50,
      status: "all",
      base_url: this.$store.state.image_base_link,
      thumbnail_img_url: this.$store.state.thumbnail_img_base_link,
      //for bulk action
       form: new Form({
        products_id: [],
        start_date: "",
        end_date: "",
      }),
      selected: false,
      options: {
        format: "YYYY-MM-DD",
        useCurrent: true,
      },
    };
  },
  methods: {


   async previewBulkPrint(){

        await this.form.post('/api/product/bulk/action/barcode/print')
        .then((resp)=>{
           console.log(resp);
           if (resp.data.status==1) {
              this.$router.push({name:'bulk_product_print_preview',params:{contents:resp.data.products}}); ;
              this.$modal.hide("product_bulk_modal");
           }
        })

    },



    //method initial for select all
    selectAll() {
      //first identify select true or false
      //we need a toggle all select box
      //if select true we make selected false, or select true
      if (this.selected == true) {
        this.selected = false;
      } else {
        this.selected = true;
      }
      //element find by the class name
      let checkBoxClass = document.getElementsByClassName("select-all");
      for (let i = 0; i < checkBoxClass.length; i++) {
        //if select active then element set attribute check==true
        //element set attribute check==false
        if (this.selected == true) {
          checkBoxClass[i].checked = true;
        } else {
          checkBoxClass[i].checked = false;
        }
      }
      //at last push order id in selected_order_id arrow....
      //and agin check selected true or false.....
      if (this.selected == true) {
        for (let i = 0; i < this.products.data.length; i++) {
          this.form.products_id.push(this.products.data[i].id);
        }
      } else {
        this.form.products_id = [];
      }

    },



     showModal() {
      if (this.form.products_id.length <=0) {
        alert("please,firstly select product ");
        return;
      }
      this.todayDate();
      this.$modal.show("product_bulk_modal");
    },


    todayDate() {
      //current date
      let d = new Date();
      //current mount
      //current day
      let month = d.getMonth() + 1;
      let day = d.getDate();
      let output = d.getFullYear() + "-" + (("" + month).length < 2 ? "0" : "") +  month + "-" + (("" + day).length < 2 ? "0" : "") + day;
      this.form.end_date = output;
    },

    productList(page = 1) {
      this.$Progress.start();
      axios
        .get("/list/product?page=" + page, {
          params: {
            status: this.status,
            item: this.item,
          },
        })
        .then((resp) => {
          console.log(resp);
          this.products = resp.data.products;
          this.$Progress.finish();
        })
        .catch((error) => {
          console.log(error);
          this.$Progress.finish();
        });
    },

    purchasePrice(items) {
      if (items.length > 0) {
        let total_price = 0;
        let total_purchase_time = 0;
        items.forEach((item) => {
          total_price += parseInt(item.price);
          total_purchase_time += 1;
        });
        let average_price = total_price / total_purchase_time;
        return average_price.toFixed(0);
      } else {
        return 0;
      }
    },

    copy($product_id) {
      let copy_items = prompt(" item of copy ?");
      if (copy_items < 1) {
        return;
      }
      axios
        .get("/api/copy/product/" + $product_id + "/" + copy_items)
        .then((resp) => {
          console.log(resp);
          if (resp.data.status == "success") {
            this.$toasted.show(resp.data.message, {
              type: "success",
              position: "top-center",
              duration: 3000,
            });
            this.productList();
          }
        });
    },


    approved(product) {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't active this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes!",
      }).then((result) => {
        if (result.value) {
          axios
            .get("/approved/product/" + product.id)
            .then((resp) => {
              //  console.log(resp)
              if (resp.data.status == "SUCCESS") {
                this.productList();
                this.$toasted.show(resp.data.message, {
                  position: "top-center",
                  type: "success",
                  duration: 4000,
                });
              } else {
                this.$toasted.show("something  went to wrong", {
                  position: "top-center",
                  type: "error",
                  duration: 4000,
                });
              }
            })
            .catch((error) => {
              // console.log(error)
              this.$toasted.show("something  went to wrong", {
                position: "top-center",
                type: "error",
                duration: 4000,
              });
            });
        } else {
          this.$toasted.show("OK ! no action here", {
            position: "top-center",
            type: "info",
            duration: 3000,
          });
        }
      });
    },
    pending(product) {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't pending this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes!",
      }).then((result) => {
        if (result.value) {
          axios
            .get("/pending/product/" + product.id)
            .then((resp) => {
              if (resp.data.status == "SUCCESS") {
                this.productList();
                this.$toasted.show(resp.data.message, {
                  position: "top-center",
                  type: "success",
                  duration: 4000,
                });
              } else {
                this.$toasted.show("something  went to wrong", {
                  position: "top-center",
                  type: "error",
                  duration: 4000,
                });
              }
            })
            .catch((error) => {
              this.$toasted.show("something  went to wrong", {
                position: "top-center",
                type: "error",
                duration: 4000,
              });
            });
        } else {
          this.$toasted.show("Ok ! no action here", {
            position: "top-center",
            type: "info",
            duration: 3000,
          });
        }
      });
    },
    deny(product) {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't deny this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes!",
      }).then((result) => {
        if (result.value) {
          axios
            .get("/deny/product/" + product.id)
            .then((resp) => {
              if (resp.data.status == "SUCCESS") {
                this.productList();
                this.$toasted.show(resp.data.message, {
                  position: "top-center",
                  type: "success",
                  duration: 4000,
                });
              } else {
                this.$toasted.show("something  went to wrong", {
                  position: "top-center",
                  type: "error",
                  duration: 4000,
                });
              }
            })
            .catch((error) => {
              this.$toasted.show("something  went to wrong", {
                position: "top-center",
                type: "error",
                duration: 4000,
              });
            });
        } else {
          this.$toasted.show("Ok ! no action here", {
            position: "top-center",
            type: "info",
            duration: 3000,
          });
        }
      });
    },
    stockUpdate(product) {
      let stock = prompt("How many stock you went to update ?");
      console.log(stock);
      axios
        .post("/stock/update/product/" + product.id, {
          stock: stock,
        })
        .then((resp) => {
          if (resp.data.status == "SUCCESS") {
            this.productList();
            this.$toasted.show(resp.data.message, {
              position: "top-center",
              type: "success",
              duration: 4000,
            });
          } else {
            this.$toasted.show("something  went to wrong", {
              position: "top-center",
              type: "error",
              duration: 4000,
            });
          }
        })
        .catch((error) => {
          this.$toasted.show("ok ! no action here", {
            position: "top-right",
            type: "info",
            duration: 4000,
          });
        });
    },
    getPagination(page = 1) {
      this.loading = true;
      this.$Progress.start();

      axios
        .get("/list/product?page=" + page)
        .then((response) => {
          this.$Progress.finish();
          this.loading = false;
          this.products = response.data.products;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    itemPerPage() {
      this.loading = true;
      this.$Progress.start();
      axios
        .get("/list/product", {
          params: {
            item: this.item,
          },
        })
        .then((resp) => {
          this.$Progress.finish();
          this.loading = false;
          if (resp.data.status == "SUCCESS") {
            this.products = resp.data.products;
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    searchProducts() {
      if (this.search.length > 1) {
        axios
          .get("/api/search/seggested/product/with/name/code/" + this.search)
          .then((resp) => {
            console.log(resp);
            if (resp.data) {
              console.log(resp.data);
              this.products = resp.data;
            } else {
              this.productList();
            }
          });
      } else {
        this.productList();
      }
    },

    changeDisplay(product) {
      let element = document.getElementById(product.id);
      element.classList.toggle("dropbtn-active");
    },
    print(productId) {
      let how_many_times = prompt(
        "How many time you went to print this product barcode?"
      );
      let url = "/product/print/barcode/" + productId + "/" + how_many_times;
      window.open(url, "_blank");
    },
  },
};
</script>

<style scoped>
.box {
  overflow-x: scroll;
}
.dropbtn {
  width: 100% !important;
  margin-bottom: 5px !important;
}
.dropbtn-active {
  display: block !important;
}
.dropdown-action {
  display: none;
  width: 90px;
  position: absolute;
}

.product_img:hover{
    transform: scale(1.5);
}

</style>
