<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Parking lot shape</title>
@vite(['resources/scss/app.scss', 'resources/js/app.js'])
<style>
  .parking-box {
    border: 2px solid #000;
    display: flex;
    justify-content: center;
    max-width: 1170px; /* Центрирование содержимого */
  }
  .parking-form {
    display: flex;
    flex-wrap: wrap; /* Позволяет элементам переноситься на новую строку */
    padding-right: 35px;
    padding-left: 35px;
    padding-bottom: 30px;
  }
  .data, .time {
    flex: 1; /* Равномерное распределение по ширине */
    padding: 10px 20px; /* Поля */
  }
.time-info
{
    padding-right: 40px;
}
.show-prices
{
padding-top: 62px;
padding-right:0;
padding-left:0;
}
.show-prices-btn {
    width: 100%; 
   padding: 10px;
   font-weight: bold;
  }
  .check
  {
    padding-top: 10px;
    padding-left: 35px;
  }
  
  .form-label
  {
    padding-left: 0;
    padding-top: 30px;
  }
  .radio-box
  {
    margin-bottom: 10px;
    display: flex;
    align-items: center; /* Выравнивание элементов по вертикали */
    flex-wrap: wrap; /* Позволяет элементам переноситься на новую строку */
    gap: 10px; /* Добавляет пространство между элементами */
    font-size: 13px;
 
  }
  .radio-box-item {
    margin-right: 10px; /* Отступ между радио и меткой */
  }
  .form-check-inline {
    display: flex;
    align-items: center;
}

  @media (max-width: 992px) {
    .time-info
{
    padding-right: 15px;
}
  }
</style>
</head>

<body>

<div class="container d-flex justify-content-center">
    
  <div class="parking-box row">
    <div class="parking-form row col-12 ">
        <div class="parking-info time-info  col-12 col-lg-5">
            <div class="row">
          <label class="form-label" for="start-date">PARKING FROM:</label>
          <input class="data col-lg-6" type="date" id="start-date" name="start-date">
          <input class="time col-lg-6" type="time" id="start-time" name="start-time">
            </div>
        </div>
        <div class="parking-info time-info col-12 col-lg-5">
            <div class="row">
          <label class="form-label" for="end-date">PARKING TO:</label>
          <input class="data col-lg-6" type="date" id="end-date" name="end-date">
          <input class="time col-lg-6" type="time" id="end-time" name="end-time">
          </div>
        </div>
        <div class="show-prices col-12 col-lg-2">
    <button class="btn btn-primary btn-block  show-prices-btn">CHECK PRICES</button>
</div>
    </div>
    <div class="col-12 check" style="background-color: #F6F6F6">
    <div class="radio-box ">
    <div class="">SHOW OFFERS FOR</div> 
    <label class="form-check-inline"><input class="radio-box-item" type="radio" name="parking" value="transport">Parking lot with direct traffic</label>
    <label class="form-check-inline"><input class="radio-box-item" type="radio" name="parking" value="airport">Official airport parking lot</label>
    </div>
</div>

  <div class="box-choice " style="background-color:#343A48">
  <div class="container-fluid row justify-content-around p-4">
  <div class="col-6 col-md-3 row">
    <div class="icon col-3">
    <img src="{{ asset('images/award.svg') }}" alt="">
    </div>
    <div class="col-9 text-left d-flex align-items-center ">
                    <span class="text-white">Best price <b>guaranteed</b></span>
                </div>
                
</div>
<div class="col-6 col-md-3  row">
    <div class="icon col-3">
    <img src="{{ asset('images/award.svg') }}" alt="">

    </div>
    <div class="col-9 text-left d-flex align-items-center ">
                    <span class="text-white">Book your spot <b>online</b></span>
                </div>
                
</div>
<div class="col-6 col-md-3  row">
    <div class="icon col-3">
            <img src="{{ asset('images/award.svg') }}" alt="">

    </div>
    <div class="col-9 text-left d-flex align-items-center ">
                    <span class="text-white"> <b>Instant</b> booking confirmation</span>
                </div>
                
</div>
<div class="col-6 col-md-3 row">
    <div class="icon col-3">
    <img src="{{ asset('images/award.svg') }}" alt="">
    </div>
             <div class="col-9 text-left d-flex align-items-center ">
                    <span class="text-white"><b>No credit card </b>needed</span>
             </div>
                
</div>
     </div>

    </div>
  </div>

</div>

</body>

</html>
