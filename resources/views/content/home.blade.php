@extends('layouts/contentLayoutMaster')

@section('title', 'Home')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<!-- Kick start -->
<div class="card">
  <div class="card-header">
    <h4 class="card-title">Food Categoires</h4>
  </div>
  <div class="row">
    <div class="col-md-6">
      <canvas id="myChart" style="width:50%;max-width:400px"></canvas>
    </div>
    <div class="col-md-6">
    <canvas id="myChart2" style="width:50%;max-width:400px"></canvas>
    </div>
  </div>
</div>

<!--/ Kick start -->

<script>

//First Graph
var xValues = [];
var Food = []

var FoodCategory = {!! json_encode($FoodCategory) !!};
var Food = {!! json_encode($foodArray) !!};

$.each(FoodCategory, function(index, value) {
  xValues.push(value.food_category_name);
})

var xValues = xValues;
var yValues = Food;
var barColors = [
  "#b91d47",
  "#00aba9",
  "#2b5797",
  "#e8c3b9",
  "#1e7145"
];

new Chart("myChart", {
  type: "pie",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    title: {
      display: true,
      text: "Food Categoires"
    }
  }
});


var MaleUsers = {!! json_encode($MaleUsers) !!};
var FemaleUsers = {!! json_encode($FemaleUsers) !!};

console.log(MaleUsers,FemaleUsers);

//Second Graph
var xValues = ["Male", "Female"];
var yValues = [MaleUsers, FemaleUsers];
var barColors = [
  "#2b5797",
  "#e8c3b9",
];

new Chart("myChart2", {
  type: "doughnut",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    title: {
      display: true,
      text: "Male and Femals Users "
    }
  }
});
</script>

@endsection
