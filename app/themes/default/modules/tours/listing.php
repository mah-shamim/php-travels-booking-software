<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?=gmkey?>&libraries=places"></script>
<script src="<?=root.theme_url?>assets/js/mixitup.min.js"></script>
<script src="<?=root.theme_url?>assets/js/mixitup-pagination.min.js"></script>
<script src="<?=root.theme_url?>assets/js/mixitup-multifilter.min.js"></script>
<script src="<?=root.theme_url?>assets/js/plugins/ion.rangeSlider.min.js"></script>

<?php $nights = round($nights / (60 * 60 * 24)); ?>

<section class="breadcrumb-area bread-bg-8">
  <div class="breadcrumb-wrap">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6">
          <div class="breadcrumb-content">
            <div class="section-heading">
              <div class="left-side-info rtl-align-right" style="color:#fff">
                <span>
                  <strong style="text-transform: capitalize">
                    <h2 class="sec__title_list"><?= T::tours_search_tours ?> <?= T::in ?> <?=$city?></h2>
                  </strong>
                </span>
                <div>
                  <p><strong><?= T::date ?> </strong>( <?=$date?> )</p>
                  <p><strong><?=$adults?></strong> <?= T::hotels_adults ?> <strong><?=$childs?></strong> <?= T::hotels_childs ?></p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php if ( empty($tours_data) ) { } else {  ?>
        <div class="col-lg-6">
          <div class="breadcrumb-list">
            <ul class="list-items d-flex justify-content-end">
              <li><i class="la la-hotel"></i> <?= T::total?> <strong><?= count($tours_data)?></strong>  <?= T::tours_tours_in?> <?=$city?></li>
            </ul>
          </div>
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
  <!-- end breadcrumb-wrap -->
  <!-- <div class="bread-svg-box">
    <svg class="bread-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 10" preserveAspectRatio="none">
        <polygon points="100 0 50 10 0 0 0 10 100 10"></polygon>
    </svg>
    </div>-->
  <!-- end bread-svg -->
</section>
<!--<div class="linear linear_listing">
  <div class="indeterminate"></div>
</div>-->

<div class="modify_search">
  <div class="container">
    <?php include 'search.php';?>
  </div>
</div>
<?php if ( empty($tours_data) ) { ?>
<div class="container text-center">
  <img src="<?=root?><?=theme_url?>assets/img/no_results.gif" alt="no results" />
</div>
<?php } else { ?>

<section>
  <div class="cd-main-content container mt-4">
    <!-- end row -->
    <div class="row">

    <div class="col-md-3 d-none d-sm-block">
      <div class="sticky-top">
        <!--<div class="viewmap mb-3">
          <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#map">View on Map</button>
          <div style="width: 100%; height: 100%; background: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB3aWR0aD0iMjc5Ljk2OSIgaGVpZ2h0PSI5MSI+CiAgICA8ZGVmcz4KICAgICAgICA8cmVjdCBpZD0iYSIgd2lkdGg9IjI3OS45NjkiIGhlaWdodD0iOTEiIC8+CiAgICAgICAgPGZpbHRlciBpZD0iYiIgd2lkdGg9IjI3OS45NjkiIGhlaWdodD0iOTEiIGZpbHRlclVuaXRzPSJvYmplY3RCb3VuZGluZ0JveCI+CiAgICAgICAgICAgIDxmZU9mZnNldCBpbj0iU291cmNlQWxwaGEiIHJlc3VsdD0ic2hhZG93T2Zmc2V0T3V0ZXIxIi8+CiAgICAgICAgICAgIDxmZUdhdXNzaWFuQmx1ciBpbj0ic2hhZG93T2Zmc2V0T3V0ZXIxIiByZXN1bHQ9InNoYWRvd0JsdXJPdXRlcjEiIC8+CiAgICAgICAgICAgIDxmZUNvbG9yTWF0cml4IGluPSJzaGFkb3dCbHVyT3V0ZXIxIiB2YWx1ZXM9IjAgMCAwIDAgMCAwIDAgMCAwIDAgMCAwIDAgMCAwIDAgMCAwIDAuMSAwIi8+CiAgICAgICAgPC9maWx0ZXI+CiAgICA8L2RlZnM+CiAgICA8ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPgogICAgICAgIDxtYXNrIGlkPSJjIiBmaWxsPSIjZmZmIj4KICAgICAgICAgICAgPHVzZSB4bGluazpocmVmPSIjYSIvPgogICAgICAgIDwvbWFzaz4KICAgICAgICA8dXNlIGZpbGw9IiMwMDAiIGZpbHRlcj0idXJsKCNiKSIgeGxpbms6aHJlZj0iI2EiLz4KICAgICAgICA8dXNlIGZpbGw9IiNGRkYiIHhsaW5rOmhyZWY9IiNhIi8+CiAgICAgICAgPGcgbWFzaz0idXJsKCNjKSI+CiAgICAgICAgICAgIDxwYXRoIGZpbGw9IiNENEU4RjQiIGQ9Ik0uMDE1IDIyOS41MzdoMjc5Ljk3Vi4wMTNILjAxNXoiLz4KICAgICAgICAgICAgPHBhdGggZmlsbD0iI0ZGRiIgZD0iTS4wMTUgMjI5LjUzN2gyNzkuOTdWLjAxM0guMDE1eiIvPgogICAgICAgICAgICA8cGF0aCBmaWxsPSIjQ0VDRUM4IiBkPSJNMCAyMjkuNTI0aDI3OS45N1YwSDB6Ii8+CiAgICAgICAgICAgIDxwYXRoIGZpbGw9IiM5NkJCRTciIGQ9Ik04OC4wMTggMjI5LjUzN2w3OC4wODktNDEuODE2YzMuNDk3LTEuODcyIDYuNjQtNC4xMTcgOS4zNjUtNi42NDlhNDAuNjAzIDQwLjYwMyAwIDAgMCAzLjI4NS0zLjQyMiAzOC4wNzIgMzguMDcyIDAgMCAwIDMuNzYyLTUuMjQyYzIuNTI0LTQuMjUyIDQuMDk5LTguODkgNC41NTMtMTMuNjc0IDEuOTg3LTIwLjkxIDE4LjkyLTM4LjgzMyA0My4xNC00NS42NjNsNDkuNzczLTE0LjAzNHYxNS4yNjVsLTQ0LjAzIDEyLjQxNmMtMTcuNTc2IDQuOTU1LTI5Ljg2NSAxNy45NjEtMzEuMzA1IDMzLjEzNS0uNTAyIDUuMjgtMiAxMC41MDYtNC4zOTkgMTUuNDMzYTQ5LjA3MyA0OS4wNzMgMCAwIDEtMy4wMTQgNS4zMSA0OS41NTIgNDkuNTUyIDAgMCAxLTIuMjQ5IDMuMTcxYy0uMTA3LjE0LS4yMTYuMjgtLjMyNS40Mi00Ljg3IDYuMjA1LTExLjM2OCAxMS41NzctMTguOTA1IDE1LjYxNGwtNTUuNTMyIDI5LjczNkg4OC4wMTh6TTE2NC44MDUuMDEzaDExNS4xOHYyOS42NjZjLTExLjkzMiAxLjE0Mi00Mi4wNjYgMy40MS02Ni4wODYuMDMtMjEuNDkyLTMuMDI0LTM5Ljk2Ny0xOS44ODItNDkuMDk0LTI5LjY5NnoiLz4KICAgICAgICAgICAgPHBhdGggZmlsbD0iI0UyRTVFNyIgZD0iTTM4LjcwNSA2My44ODZsNDUuMDg5IDIwLjQ0NyAyLjc5LTEuNDE2aC4wMDJsODQuNTgzLTQyLjkwNS0yMy4yODYtMzEuNDA1LTEwOS4xNzggNTUuMjh6bS04LjAyMyA0LjA2M0wuMDE1IDgzLjQ3NnYtNy45MjNsMjIuNDEyLTExLjM0OEwuMDE1IDU0LjA0M3YtNy43MDFMMzAuNDUgNjAuMTQzIDE0My42MSAyLjg0N2wtMi4xLTIuODM0aDkuNjA4bDI4LjMyNiAzOC4yMDJoMTAwLjU0djYuNzEySDE3Ny4xMDlsLTI1LjA3NyAxMi43MiAzNS43NjUgNDguMzYgOTIuMTg5LTI4LjE5djcuMTg1bC05MC4zMyAyNy42Mi0yMS40NzQgNTUuNDAzLTIuNDY2IDEuMzE1LTMuNTkyIDEuOTE1LS4yNi4xNC4yMDEuMDMyIDM3LjA3IDUuOTkgODAuODUgMTMuMDY5djYuODY4bC04NC45MjYtMTMuNzI2LTE5LjA4OC0zLjA4NS0yMy43ODgtMy44NDUtLjIwNS0uMDMzLS4zNTQuMTg5LTk4LjE1MSA1Mi4zM0gzOC40MDlsNjYuNTQ5LTM1LjQ4Mi02MC4zMDItODEuNTktNDQuNjQgMjIuNjQ0di03LjkyN2w3NC44NzMtMzcuOTguODQ3LS40MjkuMDQyLS4wMjItNDUuMDk2LTIwLjQ1em0xMTMuMzggMTA0LjkwM2wtNjEuMS04MC4xNy0uMDc4LjA0LS44NzEuNDQyLTMwLjM1OCAxNS4zOTkgNjAuMjA2IDgxLjQ1OSAzMi4yMDItMTcuMTd6bTYuODkzLTMuNjc0bDEwLjI4My01LjQ4MyAyMC40OS01Mi44NjItMzYuNzA1LTQ5LjYzLTU1LjA3IDI3LjkzNCA2MS4wMDIgODAuMDR6TS4wMTUgMjQuMjM1TDQ3Ljc0NC4wMTNoMTUuNjg1TC4wMTUgMzIuMTk2di03Ljk2eiIvPgogICAgICAgICAgICA8cGF0aCBmaWxsPSIjQTJDMDg5IiBkPSJNLjAxNS4wMTNoMjcuMTc4TC4wMTUgMTMuODA1Vi4wMTN6bTAgMTUwLjEyNmwyMS0xMC42NWMyLjU5My0xLjMxNiA1Ljc4My0xLjU2IDguNjI2LS42NjIgOC4xMjggMi41NjcgMTUuMzkgNi41MDQgMjEuMzgxIDExLjQ3NCA1Ljk5MiA0Ljk3MiAxMC43MTIgMTAuOTc3IDEzLjc1NCAxNy42OCAyLjU0IDUuNTk1IDMuODMgMTEuNTA0IDMuODMgMTcuNDQgMCAyLjI4LS4xOTEgNC41NjMtLjU3MyA2LjgzNWwtMS4yOSA3LjY2MmMtLjM4NiAyLjI5OC0xLjk2NiA0LjM0NS00LjMzIDUuNjE0bC00NC43NjkgMjQuMDA1SC4wMTV2LTc5LjM5OHptMTgxLjEzNi05NS42NjNoODIuOTA1YzEuMTc0IDAgMi4xMjQuNzc4IDIuMTI0IDEuNzM4djE0LjkzYzAgLjczMy0uNTY0IDEuMzg5LTEuNDA5IDEuNjM2bC03MS4yOSAyMC44NWMtLjk0NS4yNzctMS45OTgtLjAyNS0yLjUyNC0uNzI1TDE2OC4xNCA2Mi41NjJjLS42MjItLjgyNy0uMjk1LTEuOTEuNzI1LTIuNDA3bDExLjIwMi01LjQzNmEyLjQ4IDIuNDggMCAwIDEgMS4wODQtLjI0M3ptNTMuOTcgMTc1LjA2bDEuMjgyLTUuNDM4YzMuMjExLTEzLjYyIDE5LjM2My0yMi41NCAzNi4wNzUtMTkuOTIybDcuNTA3IDEuMTc2djI0LjE4NUgyMzUuMTJ6Ii8+CiAgICAgICAgICAgIDxwYXRoIGZpbGw9IiNCQkJCQjciIGQ9Ik0xNjcuMTU0IDExOC41OTRsLTkuNTQgMjQuNjcyYy0xLjQzNSAzLjcxMy03LjUyOCA0LjMwNi05Ljk4Ljk3MmwtMzUuMDY4LTQ3LjY4M2MtMi40NDUtMy4zMjUtMS4yMDUtNy42NDUgMi43OS05LjcyM2wxNy4yNC04Ljk2N2M0LjEyMi0yLjE0MyA5LjU4NS0xLjA4MyAxMi4xIDIuMzUxbDIxLjA4IDI4Ljc2OWMyLjEyIDIuODkyIDIuNjIxIDYuMzkyIDEuMzc4IDkuNjA5em0tNDMuNzktNjIuNTc1Yy0uODg0LjQ0NC0yLjAzNi4yMTItMi41NzQtLjUxOGwtMTIuMjI0LTE2LjYwN2MtLjUzOC0uNzMtLjI1Ni0xLjY4MS42MjgtMi4xMjRsMzQuMDctMTcuMDgyYy44ODQtLjQ0MiAyLjAzNi0uMjEgMi41NzMuNTE5bDEyLjIyNSAxNi42MDhjLjUzNi43My4yNTUgMS42OC0uNjI5IDIuMTIzbC0zNC4wNyAxNy4wODF6bS00My4yMDctNC4wOWwuMDE3LjAyNCAxOC42MzUtOS4yOTYuMDA4LjAxYy44NS0uNDI1IDEuOTU5LS4yMDIgMi40NzcuNDk2bDEyLjM0NSAxNi42OWMuNTE3LjY5OS4yNDYgMS42MS0uNjA1IDIuMDM0bC03Ljg1IDMuOTE2Yy0uODUuNDI0LTEuOTU4LjIwMi0yLjQ3NS0uNDk3bC0zLjAwNC00LjA2Yy0uNTE3LS42OTktMS42MjYtLjkyMi0yLjQ3Ny0uNDk3bC02LjE2NCAzLjA3NGMtLjg1LjQyNS0xLjEyMSAxLjMzNi0uNjA1IDIuMDM1bDIuOTc5IDQuMDI2Yy41MTcuNjk5LjI0NiAxLjYxLS42MDUgMi4wMzRsLTcuODUgMy45MTZjLS44NS40MjQtMS45NTguMjAyLTIuNDc1LS40OTdsLTEyLjM0Ni0xNi42OWMtLjUxNy0uNjk4LS4yNDYtMS42MDkuNjA1LTIuMDMzbDkuMzktNC42ODR6bTMzLjkwMi00My41NmMuNTQuNzI5LjI1NiAxLjY3OC0uNjMyIDIuMTJMODIuMzYxIDI1Ljk2Yy0uODg4LjQ0Mi0yLjA0NS4yMS0yLjU4NS0uNTE3bC00Ljg1OC02LjU1NWMtLjUzOC0uNzI4LS4yNTYtMS42NzcuNjMyLTIuMTJsMzEuMDY2LTE1LjQ2OWMuODg4LS40NDIgMi4wNDYtLjIxIDIuNTg2LjUxOGw0Ljg1NyA2LjU1M3ptLTQ4LjYzLTIuNTRjLS41NC0uNzI1LS4yNTgtMS42NzIuNjMtMi4xMTJMNzMuNTMuMDEzaDI1LjI3NGwtMjUuOTMgMTIuODYxYy0uODg5LjQ0MS0yLjA0Ny4yMS0yLjU4Ny0uNTE2TDY1LjQzIDUuODN6bS0zMy45NDcgNDUuMjRjLS44ODQuNDQyLTIuMDM2LjIxLTIuNTczLS41MThMMTYuNjggMzMuOTU3Yy0uNTM4LS43MjktLjI1Ni0xLjY3OC42MjgtMi4xMjFsMzguMzc5LTE5LjIyYy44ODUtLjQ0MyAyLjAzNy0uMjEyIDIuNTc1LjUxN0w3MC40OSAyOS43MjdjLjUzNi43MjguMjU1IDEuNjc4LS42MyAyLjEyMWwtMzguMzc5IDE5LjIyek0uMDE1IDkxLjI5N2wyOC4wMTYtMTMuOTYzYy44ODctLjQ0MSAyLjA0NC0uMjEgMi41ODIuNTE3TDQyLjg4IDk0LjQxOGMuNTQuNzI3LjI1NyAxLjY3NS0uNjMgMi4xMThMMS40OSAxMTYuODVjLS40Ni4yMjktLjk5My4yNzctMS40NzUuMTY3di0yNS43MnptMTk0LjEyNCAxMzguMjRsNC40MjQtMTguOTQyYy4yNDUtMS4wNSAxLjQ3OC0xLjczNyAyLjc1My0xLjUzNWwyNy4xNTIgNC4yOTRjMS4yNzQuMjAxIDIuMTEgMS4yMTUgMS44NjQgMi4yNjVsLTMuMjUgMTMuOTE4SDE5NC4xNHptOS4yNS0yNS43ODdjLTEuMjgxLS4yLTIuMTItMS4xOTgtMS44NzQtMi4yMzFsMS41NS02LjUwOWMuMjQ3LTEuMDM0IDEuNDg0LTEuNzEgMi43NjQtMS41MTJsMjYuOTQ0IDQuMThjMS4yOC4xOTggMi4xMTkgMS4xOTcgMS44NzMgMi4yM2wtMS41NSA2LjUxYy0uMjQ2IDEuMDMzLTEuNDgzIDEuNzEtMi43NjQgMS41MTFsLTI2Ljk0NC00LjE4em01NS4yMDUtMjYuNzMxYy0xLjI3Mi0uMi0yLjEwNy0xLjIwNS0xLjg2MS0yLjI0NGwzLjYzOS0xNS40NzVjLjI0NC0xLjA0IDEuNDc1LTEuNzIxIDIuNzQ2LTEuNTJsMTYuODY3IDIuNjQ4djE5Ljk1bC0yMS4zOS0zLjM1OXptLTExLjY0My0yNy4yNjhjLTEuMjc1LS4xOTktMi4xMTItMS4yMDMtMS44NjYtMi4yNGwzLjY0OS0xNS40NDZjLjI0Ni0xLjAzNyAxLjQ3OS0xLjcxOCAyLjc1NS0xLjUxOGwyOC40OTYgNC40NTV2MTkuOTEzbC0zMy4wMzQtNS4xNjR6bS0yOS43NzQgMjAuMDg4Yy0xLjI3LS4yLTIuMTAxLTEuMjEtMS44NTgtMi4yNTVsMS45MzMtOC4yNzZjLjI0NC0xLjA0NSAxLjQ3Mi0xLjczIDIuNzQxLTEuNTI5bDI2LjE2OSA0LjEzOGMxLjI3LjIwMiAyLjEwMSAxLjIxMSAxLjg1OCAyLjI1N2wtMS45MzMgOC4yNzRjLS4yNDQgMS4wNDYtMS40NzIgMS43My0yLjc0MSAxLjUzbC0yNi4xNjktNC4xMzl6TTc2LjcxMiAxMjUuMzNjLS42NzUtLjkxMy0uMzE4LTIuMS43OTctMi42NTFMODguOTc0IDExN2MxLjExNS0uNTUyIDIuNTY1LS4yNiAzLjI0LjY1M2wyMC45MTUgMjguM2MuNjc0LjkxMi4zMTggMi4xLS43OTggMi42NTJsLTExLjQ2NSA1LjY3OGMtMS4xMTQuNTUyLTIuNTY0LjI2LTMuMjM4LS42NTJsLTIwLjkxNi0yOC4zMDJ6bTI2LjMyNyAzNS43MjNjLS43LS45NDYtLjMzLTIuMTc2LjgyNy0yLjc0OGwxMS4yNi01LjU3NWMxLjE1NS0uNTcyIDIuNjYtLjI3IDMuMzU4LjY3Nmw4Ljc4IDExLjg3M2MyLjU4IDMuNDkgMS4yMTUgOC4wMzEtMy4wNTEgMTAuMTQyLTQuMjY1IDIuMTEyLTkuODE0Ljk5NC0xMi4zOTUtMi40OTVsLTguNzgtMTEuODczem0tMzcuOTc0LTUwLjk4NmMtLjY3Ni0uOTA2LS4zMTgtMi4wODUuOC0yLjYzM2wxMS41MDUtNS42NDNjMS4xMTgtLjU0OCAyLjU3NC0uMjU5IDMuMjUuNjQ5bDUuMzMgNy4xNDJjLjY3Ny45MDYuMzE5IDIuMDg1LS44IDIuNjM0bC0xMS41MDQgNS42NDJjLTEuMTE4LjU0OS0yLjU3NC4yNTgtMy4yNS0uNjQ4bC01LjMzLTcuMTQzem0xMDkuNjYyIDExOS40N2w1LjA0NS0yMS43NjZjLjI0NC0xLjA1MyAxLjQ3LTEuNzQxIDIuNzM5LTEuNTRsNS44NDguOTMyYzEuMjY4LjIwMyAyLjEgMS4yMiAxLjg1NSAyLjI3MmwtNC42NiAyMC4xMDNoLTEwLjgyN3oiLz4KICAgICAgICA8L2c+CiAgICA8L2c+Cjwvc3ZnPgo=)" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB3aWR0aD0iMjc5Ljk2OSIgaGVpZ2h0PSI5MSI+CiAgICA8ZGVmcz4KICAgICAgICA8cmVjdCBpZD0iYSIgd2lkdGg9IjI3OS45NjkiIGhlaWdodD0iOTEiIC8+CiAgICAgICAgPGZpbHRlciBpZD0iYiIgd2lkdGg9IjI3OS45NjkiIGhlaWdodD0iOTEiIGZpbHRlclVuaXRzPSJvYmplY3RCb3VuZGluZ0JveCI+CiAgICAgICAgICAgIDxmZU9mZnNldCBpbj0iU291cmNlQWxwaGEiIHJlc3VsdD0ic2hhZG93T2Zmc2V0T3V0ZXIxIi8+CiAgICAgICAgICAgIDxmZUdhdXNzaWFuQmx1ciBpbj0ic2hhZG93T2Zmc2V0T3V0ZXIxIiByZXN1bHQ9InNoYWRvd0JsdXJPdXRlcjEiIC8+CiAgICAgICAgICAgIDxmZUNvbG9yTWF0cml4IGluPSJzaGFkb3dCbHVyT3V0ZXIxIiB2YWx1ZXM9IjAgMCAwIDAgMCAwIDAgMCAwIDAgMCAwIDAgMCAwIDAgMCAwIDAuMSAwIi8+CiAgICAgICAgPC9maWx0ZXI+CiAgICA8L2RlZnM+CiAgICA8ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPgogICAgICAgIDxtYXNrIGlkPSJjIiBmaWxsPSIjZmZmIj4KICAgICAgICAgICAgPHVzZSB4bGluazpocmVmPSIjYSIvPgogICAgICAgIDwvbWFzaz4KICAgICAgICA8dXNlIGZpbGw9IiMwMDAiIGZpbHRlcj0idXJsKCNiKSIgeGxpbms6aHJlZj0iI2EiLz4KICAgICAgICA8dXNlIGZpbGw9IiNGRkYiIHhsaW5rOmhyZWY9IiNhIi8+CiAgICAgICAgPGcgbWFzaz0idXJsKCNjKSI+CiAgICAgICAgICAgIDxwYXRoIGZpbGw9IiNENEU4RjQiIGQ9Ik0uMDE1IDIyOS41MzdoMjc5Ljk3Vi4wMTNILjAxNXoiLz4KICAgICAgICAgICAgPHBhdGggZmlsbD0iI0ZGRiIgZD0iTS4wMTUgMjI5LjUzN2gyNzkuOTdWLjAxM0guMDE1eiIvPgogICAgICAgICAgICA8cGF0aCBmaWxsPSIjQ0VDRUM4IiBkPSJNMCAyMjkuNTI0aDI3OS45N1YwSDB6Ii8+CiAgICAgICAgICAgIDxwYXRoIGZpbGw9IiM5NkJCRTciIGQ9Ik04OC4wMTggMjI5LjUzN2w3OC4wODktNDEuODE2YzMuNDk3LTEuODcyIDYuNjQtNC4xMTcgOS4zNjUtNi42NDlhNDAuNjAzIDQwLjYwMyAwIDAgMCAzLjI4NS0zLjQyMiAzOC4wNzIgMzguMDcyIDAgMCAwIDMuNzYyLTUuMjQyYzIuNTI0LTQuMjUyIDQuMDk5LTguODkgNC41NTMtMTMuNjc0IDEuOTg3LTIwLjkxIDE4LjkyLTM4LjgzMyA0My4xNC00NS42NjNsNDkuNzczLTE0LjAzNHYxNS4yNjVsLTQ0LjAzIDEyLjQxNmMtMTcuNTc2IDQuOTU1LTI5Ljg2NSAxNy45NjEtMzEuMzA1IDMzLjEzNS0uNTAyIDUuMjgtMiAxMC41MDYtNC4zOTkgMTUuNDMzYTQ5LjA3MyA0OS4wNzMgMCAwIDEtMy4wMTQgNS4zMSA0OS41NTIgNDkuNTUyIDAgMCAxLTIuMjQ5IDMuMTcxYy0uMTA3LjE0LS4yMTYuMjgtLjMyNS40Mi00Ljg3IDYuMjA1LTExLjM2OCAxMS41NzctMTguOTA1IDE1LjYxNGwtNTUuNTMyIDI5LjczNkg4OC4wMTh6TTE2NC44MDUuMDEzaDExNS4xOHYyOS42NjZjLTExLjkzMiAxLjE0Mi00Mi4wNjYgMy40MS02Ni4wODYuMDMtMjEuNDkyLTMuMDI0LTM5Ljk2Ny0xOS44ODItNDkuMDk0LTI5LjY5NnoiLz4KICAgICAgICAgICAgPHBhdGggZmlsbD0iI0UyRTVFNyIgZD0iTTM4LjcwNSA2My44ODZsNDUuMDg5IDIwLjQ0NyAyLjc5LTEuNDE2aC4wMDJsODQuNTgzLTQyLjkwNS0yMy4yODYtMzEuNDA1LTEwOS4xNzggNTUuMjh6bS04LjAyMyA0LjA2M0wuMDE1IDgzLjQ3NnYtNy45MjNsMjIuNDEyLTExLjM0OEwuMDE1IDU0LjA0M3YtNy43MDFMMzAuNDUgNjAuMTQzIDE0My42MSAyLjg0N2wtMi4xLTIuODM0aDkuNjA4bDI4LjMyNiAzOC4yMDJoMTAwLjU0djYuNzEySDE3Ny4xMDlsLTI1LjA3NyAxMi43MiAzNS43NjUgNDguMzYgOTIuMTg5LTI4LjE5djcuMTg1bC05MC4zMyAyNy42Mi0yMS40NzQgNTUuNDAzLTIuNDY2IDEuMzE1LTMuNTkyIDEuOTE1LS4yNi4xNC4yMDEuMDMyIDM3LjA3IDUuOTkgODAuODUgMTMuMDY5djYuODY4bC04NC45MjYtMTMuNzI2LTE5LjA4OC0zLjA4NS0yMy43ODgtMy44NDUtLjIwNS0uMDMzLS4zNTQuMTg5LTk4LjE1MSA1Mi4zM0gzOC40MDlsNjYuNTQ5LTM1LjQ4Mi02MC4zMDItODEuNTktNDQuNjQgMjIuNjQ0di03LjkyN2w3NC44NzMtMzcuOTguODQ3LS40MjkuMDQyLS4wMjItNDUuMDk2LTIwLjQ1em0xMTMuMzggMTA0LjkwM2wtNjEuMS04MC4xNy0uMDc4LjA0LS44NzEuNDQyLTMwLjM1OCAxNS4zOTkgNjAuMjA2IDgxLjQ1OSAzMi4yMDItMTcuMTd6bTYuODkzLTMuNjc0bDEwLjI4My01LjQ4MyAyMC40OS01Mi44NjItMzYuNzA1LTQ5LjYzLTU1LjA3IDI3LjkzNCA2MS4wMDIgODAuMDR6TS4wMTUgMjQuMjM1TDQ3Ljc0NC4wMTNoMTUuNjg1TC4wMTUgMzIuMTk2di03Ljk2eiIvPgogICAgICAgICAgICA8cGF0aCBmaWxsPSIjQTJDMDg5IiBkPSJNLjAxNS4wMTNoMjcuMTc4TC4wMTUgMTMuODA1Vi4wMTN6bTAgMTUwLjEyNmwyMS0xMC42NWMyLjU5My0xLjMxNiA1Ljc4My0xLjU2IDguNjI2LS42NjIgOC4xMjggMi41NjcgMTUuMzkgNi41MDQgMjEuMzgxIDExLjQ3NCA1Ljk5MiA0Ljk3MiAxMC43MTIgMTAuOTc3IDEzLjc1NCAxNy42OCAyLjU0IDUuNTk1IDMuODMgMTEuNTA0IDMuODMgMTcuNDQgMCAyLjI4LS4xOTEgNC41NjMtLjU3MyA2LjgzNWwtMS4yOSA3LjY2MmMtLjM4NiAyLjI5OC0xLjk2NiA0LjM0NS00LjMzIDUuNjE0bC00NC43NjkgMjQuMDA1SC4wMTV2LTc5LjM5OHptMTgxLjEzNi05NS42NjNoODIuOTA1YzEuMTc0IDAgMi4xMjQuNzc4IDIuMTI0IDEuNzM4djE0LjkzYzAgLjczMy0uNTY0IDEuMzg5LTEuNDA5IDEuNjM2bC03MS4yOSAyMC44NWMtLjk0NS4yNzctMS45OTgtLjAyNS0yLjUyNC0uNzI1TDE2OC4xNCA2Mi41NjJjLS42MjItLjgyNy0uMjk1LTEuOTEuNzI1LTIuNDA3bDExLjIwMi01LjQzNmEyLjQ4IDIuNDggMCAwIDEgMS4wODQtLjI0M3ptNTMuOTcgMTc1LjA2bDEuMjgyLTUuNDM4YzMuMjExLTEzLjYyIDE5LjM2My0yMi41NCAzNi4wNzUtMTkuOTIybDcuNTA3IDEuMTc2djI0LjE4NUgyMzUuMTJ6Ii8+CiAgICAgICAgICAgIDxwYXRoIGZpbGw9IiNCQkJCQjciIGQ9Ik0xNjcuMTU0IDExOC41OTRsLTkuNTQgMjQuNjcyYy0xLjQzNSAzLjcxMy03LjUyOCA0LjMwNi05Ljk4Ljk3MmwtMzUuMDY4LTQ3LjY4M2MtMi40NDUtMy4zMjUtMS4yMDUtNy42NDUgMi43OS05LjcyM2wxNy4yNC04Ljk2N2M0LjEyMi0yLjE0MyA5LjU4NS0xLjA4MyAxMi4xIDIuMzUxbDIxLjA4IDI4Ljc2OWMyLjEyIDIuODkyIDIuNjIxIDYuMzkyIDEuMzc4IDkuNjA5em0tNDMuNzktNjIuNTc1Yy0uODg0LjQ0NC0yLjAzNi4yMTItMi41NzQtLjUxOGwtMTIuMjI0LTE2LjYwN2MtLjUzOC0uNzMtLjI1Ni0xLjY4MS42MjgtMi4xMjRsMzQuMDctMTcuMDgyYy44ODQtLjQ0MiAyLjAzNi0uMjEgMi41NzMuNTE5bDEyLjIyNSAxNi42MDhjLjUzNi43My4yNTUgMS42OC0uNjI5IDIuMTIzbC0zNC4wNyAxNy4wODF6bS00My4yMDctNC4wOWwuMDE3LjAyNCAxOC42MzUtOS4yOTYuMDA4LjAxYy44NS0uNDI1IDEuOTU5LS4yMDIgMi40NzcuNDk2bDEyLjM0NSAxNi42OWMuNTE3LjY5OS4yNDYgMS42MS0uNjA1IDIuMDM0bC03Ljg1IDMuOTE2Yy0uODUuNDI0LTEuOTU4LjIwMi0yLjQ3NS0uNDk3bC0zLjAwNC00LjA2Yy0uNTE3LS42OTktMS42MjYtLjkyMi0yLjQ3Ny0uNDk3bC02LjE2NCAzLjA3NGMtLjg1LjQyNS0xLjEyMSAxLjMzNi0uNjA1IDIuMDM1bDIuOTc5IDQuMDI2Yy41MTcuNjk5LjI0NiAxLjYxLS42MDUgMi4wMzRsLTcuODUgMy45MTZjLS44NS40MjQtMS45NTguMjAyLTIuNDc1LS40OTdsLTEyLjM0Ni0xNi42OWMtLjUxNy0uNjk4LS4yNDYtMS42MDkuNjA1LTIuMDMzbDkuMzktNC42ODR6bTMzLjkwMi00My41NmMuNTQuNzI5LjI1NiAxLjY3OC0uNjMyIDIuMTJMODIuMzYxIDI1Ljk2Yy0uODg4LjQ0Mi0yLjA0NS4yMS0yLjU4NS0uNTE3bC00Ljg1OC02LjU1NWMtLjUzOC0uNzI4LS4yNTYtMS42NzcuNjMyLTIuMTJsMzEuMDY2LTE1LjQ2OWMuODg4LS40NDIgMi4wNDYtLjIxIDIuNTg2LjUxOGw0Ljg1NyA2LjU1M3ptLTQ4LjYzLTIuNTRjLS41NC0uNzI1LS4yNTgtMS42NzIuNjMtMi4xMTJMNzMuNTMuMDEzaDI1LjI3NGwtMjUuOTMgMTIuODYxYy0uODg5LjQ0MS0yLjA0Ny4yMS0yLjU4Ny0uNTE2TDY1LjQzIDUuODN6bS0zMy45NDcgNDUuMjRjLS44ODQuNDQyLTIuMDM2LjIxLTIuNTczLS41MThMMTYuNjggMzMuOTU3Yy0uNTM4LS43MjktLjI1Ni0xLjY3OC42MjgtMi4xMjFsMzguMzc5LTE5LjIyYy44ODUtLjQ0MyAyLjAzNy0uMjEyIDIuNTc1LjUxN0w3MC40OSAyOS43MjdjLjUzNi43MjguMjU1IDEuNjc4LS42MyAyLjEyMWwtMzguMzc5IDE5LjIyek0uMDE1IDkxLjI5N2wyOC4wMTYtMTMuOTYzYy44ODctLjQ0MSAyLjA0NC0uMjEgMi41ODIuNTE3TDQyLjg4IDk0LjQxOGMuNTQuNzI3LjI1NyAxLjY3NS0uNjMgMi4xMThMMS40OSAxMTYuODVjLS40Ni4yMjktLjk5My4yNzctMS40NzUuMTY3di0yNS43MnptMTk0LjEyNCAxMzguMjRsNC40MjQtMTguOTQyYy4yNDUtMS4wNSAxLjQ3OC0xLjczNyAyLjc1My0xLjUzNWwyNy4xNTIgNC4yOTRjMS4yNzQuMjAxIDIuMTEgMS4yMTUgMS44NjQgMi4yNjVsLTMuMjUgMTMuOTE4SDE5NC4xNHptOS4yNS0yNS43ODdjLTEuMjgxLS4yLTIuMTItMS4xOTgtMS44NzQtMi4yMzFsMS41NS02LjUwOWMuMjQ3LTEuMDM0IDEuNDg0LTEuNzEgMi43NjQtMS41MTJsMjYuOTQ0IDQuMThjMS4yOC4xOTggMi4xMTkgMS4xOTcgMS44NzMgMi4yM2wtMS41NSA2LjUxYy0uMjQ2IDEuMDMzLTEuNDgzIDEuNzEtMi43NjQgMS41MTFsLTI2Ljk0NC00LjE4em01NS4yMDUtMjYuNzMxYy0xLjI3Mi0uMi0yLjEwNy0xLjIwNS0xLjg2MS0yLjI0NGwzLjYzOS0xNS40NzVjLjI0NC0xLjA0IDEuNDc1LTEuNzIxIDIuNzQ2LTEuNTJsMTYuODY3IDIuNjQ4djE5Ljk1bC0yMS4zOS0zLjM1OXptLTExLjY0My0yNy4yNjhjLTEuMjc1LS4xOTktMi4xMTItMS4yMDMtMS44NjYtMi4yNGwzLjY0OS0xNS40NDZjLjI0Ni0xLjAzNyAxLjQ3OS0xLjcxOCAyLjc1NS0xLjUxOGwyOC40OTYgNC40NTV2MTkuOTEzbC0zMy4wMzQtNS4xNjR6bS0yOS43NzQgMjAuMDg4Yy0xLjI3LS4yLTIuMTAxLTEuMjEtMS44NTgtMi4yNTVsMS45MzMtOC4yNzZjLjI0NC0xLjA0NSAxLjQ3Mi0xLjczIDIuNzQxLTEuNTI5bDI2LjE2OSA0LjEzOGMxLjI3LjIwMiAyLjEwMSAxLjIxMSAxLjg1OCAyLjI1N2wtMS45MzMgOC4yNzRjLS4yNDQgMS4wNDYtMS40NzIgMS43My0yLjc0MSAxLjUzbC0yNi4xNjktNC4xMzl6TTc2LjcxMiAxMjUuMzNjLS42NzUtLjkxMy0uMzE4LTIuMS43OTctMi42NTFMODguOTc0IDExN2MxLjExNS0uNTUyIDIuNTY1LS4yNiAzLjI0LjY1M2wyMC45MTUgMjguM2MuNjc0LjkxMi4zMTggMi4xLS43OTggMi42NTJsLTExLjQ2NSA1LjY3OGMtMS4xMTQuNTUyLTIuNTY0LjI2LTMuMjM4LS42NTJsLTIwLjkxNi0yOC4zMDJ6bTI2LjMyNyAzNS43MjNjLS43LS45NDYtLjMzLTIuMTc2LjgyNy0yLjc0OGwxMS4yNi01LjU3NWMxLjE1NS0uNTcyIDIuNjYtLjI3IDMuMzU4LjY3Nmw4Ljc4IDExLjg3M2MyLjU4IDMuNDkgMS4yMTUgOC4wMzEtMy4wNTEgMTAuMTQyLTQuMjY1IDIuMTEyLTkuODE0Ljk5NC0xMi4zOTUtMi40OTVsLTguNzgtMTEuODczem0tMzcuOTc0LTUwLjk4NmMtLjY3Ni0uOTA2LS4zMTgtMi4wODUuOC0yLjYzM2wxMS41MDUtNS42NDNjMS4xMTgtLjU0OCAyLjU3NC0uMjU5IDMuMjUuNjQ5bDUuMzMgNy4xNDJjLjY3Ny45MDYuMzE5IDIuMDg1LS44IDIuNjM0bC0xMS41MDQgNS42NDJjLTEuMTE4LjU0OS0yLjU3NC4yNTgtMy4yNS0uNjQ4bC01LjMzLTcuMTQzem0xMDkuNjYyIDExOS40N2w1LjA0NS0yMS43NjZjLjI0NC0xLjA1MyAxLjQ3LTEuNzQxIDIuNzM5LTEuNTRsNS44NDguOTMyYzEuMjY4LjIwMyAyLjEgMS4yMiAxLjg1NSAyLjI3MmwtNC42NiAyMC4xMDNoLTEwLjgyN3oiLz4KICAgICAgICA8L2c+CiAgICA8L2c+Cjwvc3ZnPgo="></div>
        </div>-->
        <!-- map -->
        <div class="modal fade" id="map" tabindex="-1" aria-labelledby="map" aria-hidden="true">
          <div class="modal-dialog container">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?=T::hotels_hotelsonmap?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div id="map-canvas" style="height:400px"></div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        <div class="card-header">
          <strong><?=T::filtersearch?></strong>
        </div>
        <div class="sidebar mt-0">
          <div class="sidebar-widget controls">
            <form>
              <div class="sidebar-box mb-4">

              <div class="sidebar-widget" data-filter-group>
                <h3 class="title stroke-shape"><?=T::searchbyname?></h3>
                <input type="text" class="form-control" placeholder="<?=T::hotels_hotelname?>" value="" data-search-attribute="id" />
              </div>

                <h3 class="title stroke-shape" style="text-transform:capitalize"><?=T::stargrade?></h3>
                <ul class="list remove_duplication" data-filter-group>

                  <li>
                    <div class="custom-checkbox">
                      <input class="filter" type="checkbox" id="stars_1" value=".stars_1">
                      <label class="custom-control-label" for="stars_1">
                        <strong>1</strong> &nbsp;
                        <span class="stars la la-star"></span>
                        <div class="stars la la-star-o"></div>
                        <div class="stars la la-star-o"></div>
                        <div class="stars la la-star-o"></div>
                        <div class="stars la la-star-o"></div>
                      </label>
                    </div>
                  </li>
                  <!-- 2 stars -->
                  <li>
                    <div class="custom-checkbox">
                      <input class="filter" type="checkbox" id="stars_2" value=".stars_2">
                      <label class="custom-control-label" for="stars_2">
                        <strong>2</strong> &nbsp;
                        <span class="stars la la-star"></span>
                        <span class="stars la la-star"></span>
                        <div class="stars la la-star-o"></div>
                        <div class="stars la la-star-o"></div>
                        <div class="stars la la-star-o"></div>
                      </label>
                    </div>
                  </li>
                  <!-- 3 stars -->
                  <li>
                    <div class="custom-checkbox">
                      <input class="filter" type="checkbox" id="stars_3" value=".stars_3">
                      <label class="custom-control-label" for="stars_3">
                        <strong>3</strong> &nbsp;
                        <span class="stars la la-star"></span>
                        <span class="stars la la-star"></span>
                        <span class="stars la la-star"></span>
                        <div class="stars la la-star-o"></div>
                        <div class="stars la la-star-o"></div>
                      </label>
                    </div>
                  </li>
                  <!-- 4 stars -->
                  <li>
                    <div class="custom-checkbox">
                      <input class="filter" type="checkbox" id="stars_4" value=".stars_4">
                      <label class="custom-control-label" for="stars_4">
                        <strong>4</strong> &nbsp;
                        <span class="stars la la-star"></span>
                        <span class="stars la la-star"></span>
                        <span class="stars la la-star"></span>
                        <span class="stars la la-star"></span>
                        <div class="stars la la-star-o"></div>
                      </label>
                    </div>
                  </li>
                  <!-- 5 stars -->
                  <li>
                    <div class="custom-checkbox">
                      <input class="filter" type="checkbox" id="stars_5" value=".stars_5">
                      <label class="custom-control-label" for="stars_5"><strong>5</strong> &nbsp;
                      <span class="stars la la-star"></span>
                      <span class="stars la la-star"></span>
                      <span class="stars la la-star"></span>
                      <span class="stars la la-star"></span>
                      <span class="stars la la-star"></span>
                      </label>
                    </div>
                  </li>
                </ul>
              </div>
              <div class="sidebar-widget">
                <h3 class="title stroke-shape"><?=T::pricerange?></h3>
                <div class="sidebar-price-range">
                  <div class="main-search-input-item">
                    <div class="range-sliderrr">
                     <input type="text" class="js-range-slider" data-ref="range-slider-a" value="" />
                     </div>
                     <div class="range-sliderrr" style="display:none">
                      <input type="text" class="js-range-slider" data-ref="range-slider-b" value="" />
                    </div>
                  </div>
                </div>
              </div>

              <!--<div class="sidebar-box mb-4 controls">
                <h3 class="title stroke-shape" style="text-transform:capitalize"><?=T::hotels_hotelamenities?></h3>
                <ul class="cd-filter-content cd-filters list remove_duplication" style="height: 400px; overflow: auto;" data-filter-group>
                </ul>
              </div>-->
              <!--<div class="sidebar-box">
                <div class="box-content">
                  <button type="submit" class="btn btn-primary btn-lg btn-block" id="searchform"><?=T::search?></button>
                </div>
                </div>-->

              </form>
          </div>
        </div>
      </div>
      </div>

      <!-- end col-lg-4 -->
      <div class="col-lg-9" id="markers">

      <?= signupdeals();?>

        <section data-ref="container" id="data">
          <ul>
            <?php foreach ($tours_data as $index => $item) {
            if (empty($item->country_code)) { $item->country_code = "0"; }
            $link = root.$session_lang.'/'.strtolower($currency).'/tour/'.strtolower(str_replace(' ', '-', $city)).'/'.strtolower(str_replace(" ", "-", $item->name)).'/'.$item->tour_id.'/'.$date.'/'.$adults.'/'.$childs.'/'.$item->supplier;
            if (isset($img)) {
            $hotel_img = $img; } else {
            $hotel_img = root."app/themes/default/assets/img/data/hotel.jpg";
            }
            ?>
            <li class="mix stars_<?=$item->rating?> hotels_amenities_" data-a="<?=$item->b2c_price?>" data-b="" id="<?=strtolower($item->name)?>">
              <div class="card-item card-item-list" class="marker-link row row-rtl item hotelslist">
                <div class="card-img">
                  <a href="<?=$link?>" class="d-block">
                  <img data-src="<?=$item->img?>" class="main-img lazyload" alt="thumbnail" />
                  </a>
                  <!--<div class="add-to-wishlist icon-element" data-toggle="tooltip" data-placement="top" title="Bookmark">
                    <i class="la la-heart-o"></i>
                    </div>-->
                </div>
                <div class="card-body p-0">

                  <div class="row">
                  <div class="col-8 px-4 p-3">
                  <h3 class="card-title"><?=str_replace('-', ' ', $item->name);?></h3>
                  <p class="card-meta"><i class="la la-map-marker"></i> <?= $_SESSION['tours_location'] // $item->location?></p>
                  <!--<p class="card-meta"><p>This 5-star luxury hotel offers a 25-metre heated pool and a tennis court minutes from the banks of Swan River and Perth&rsquo;s city centre. A free&#8230;</p>-->
                  <a class="ellipsisFIX go-text-right mob-fs14" href="javascript:void(0);" onclick="showMap('http://localhost/v8/home/maps/-31.95819269999999/115.86670630000003/hotels/38','modal');" title="dubai">
                  </a>

                  <div class="card-rating pt-0 pb-0">
                    <!--<span class="badge text-white"><?=$item->rating?></span>-->
                    <span class="review__text">
                      <?php for ($i = 1; $i <= $item->rating; $i++) { ?>
                      <div class="rating la la-star"></div>
                      <?php } ?>
                    </span>
                    <hr style="margin:8px 0;color: #c6ccd3;">
                    <span class="rating__text"><span style="border: 0.4px solid #62a0ff; padding: 6px 11px; border-radius: 18px; margin-right: 8px;"><?=$item->rating?></span> <?=T::ratings?></span>
                  </div>
                  </div>

                  <div class="col-4 p-3" style="background: #e4e8ef;min-height: 160px;border: 1px solid #e2e7ec;">
                    <div class="card-price">
                      <span class="price__from"><?=T::startsfrom?></span>
                      <div class="clear"></div>

                      <?php if(isset($_SESSION["user_type"])) { if ($_SESSION["user_type"] == "agent") { ?>
                      <p class="mb-0"><span class="price__num"><small><?=$currency?></small> <strong><?=$item->b2b_price?> <span class="prices"><?=T::agent_price?></span></strong><div class="clear"></div></span></p>
                      <!--<p class="mb-0"><span class="price__num"><small><?=$currency?></small> <strong><?=$item->b2c_price?> <span class="prices"><?=T::customer_price?></span></strong><div class="clear"></div></span></p>-->
                      <?php } else { ?>
                      <p class="mb-0"><span class="price__num"><small><?=$currency?></small> <strong><?=$item->b2c_price?></strong></span></p>
                      <?php } } ?>

                      <?php if (!isset($_SESSION["user_type"])) { ?>
                      <p class="mb-0"><span class="price__num"><small><?=$currency?></small> <strong><?=$item->b2c_price?></strong></span></p>
                      <?php }?>

                      <div class="clear"></div>
                      <br>
                        <a href="<?=$link?>" class="more_details effect mt-0 btn-block" data-style="zoom-in">
                          <?=T::details?><i class="la la-angle-right"></i>
                        </a>
                        <?php if (!empty($item->discount)){?>
                        <span class="badge badge-success mt-2 btn-block"><?=T::discounts?> <?=$item->discount?> %</span>
                        <img style="float: right; position: absolute; bottom: 110px; right: 10px;" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzMCIgaGVpZ2h0PSIzNCIgdmlld0JveD0iMCAwIDMwIDM0Ij4KICAgIDxkZWZzPgogICAgICAgIDxsaW5lYXJHcmFkaWVudCBpZD0iYSIgeDE9IjUwJSIgeDI9IjUwJSIgeTE9IjUwJSIgeTI9Ijk2LjElIj4KICAgICAgICAgICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iI0UwQjk1MyIvPgogICAgICAgICAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiNCQTkxMTkiLz4KICAgICAgICA8L2xpbmVhckdyYWRpZW50PgogICAgICAgIDxsaW5lYXJHcmFkaWVudCBpZD0iYiIgeDE9IjUwJSIgeDI9IjUwJSIgeTE9IjEuNDI4JSIgeTI9Ijk2LjElIj4KICAgICAgICAgICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iI0UwQjk1MyIvPgogICAgICAgICAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiNCQTkxMTkiLz4KICAgICAgICA8L2xpbmVhckdyYWRpZW50PgogICAgPC9kZWZzPgogICAgPGcgZmlsbD0ibm9uZSIgZmlsbC1ydWxlPSJldmVub2RkIj4KICAgICAgICA8ZyB0cmFuc2Zvcm09InRyYW5zbGF0ZSgzKSI+CiAgICAgICAgICAgIDxwYXRoIGZpbGw9InVybCgjYSkiIGQ9Ik0yMS43NTYgMzAuMDY3bC00LjE5My0xLjU3Mi0yLjQyNiAzLjY0OS02LjE0OC0xOC4zNCA2LjYxOC0yLjE0NnoiIHRyYW5zZm9ybT0icm90YXRlKC00IDE1LjM3MiAyMS45KSIvPgogICAgICAgICAgICA8cGF0aCBmaWxsPSJ1cmwoI2EpIiBkPSJNMi41ODkgMzAuMDY3bDQuMTkzLTEuNTcyIDIuNDI1IDMuNjQ5IDYuMTUtMTguMzQtNi42Mi0yLjE0NnoiIHRyYW5zZm9ybT0icm90YXRlKDQgOC45NzMgMjEuOSkiLz4KICAgICAgICAgICAgPHBhdGggZmlsbD0idXJsKCNiKSIgc3Ryb2tlPSIjRkZGIiBzdHJva2Utd2lkdGg9Ii41IiBkPSJNMjQgMTIuMzc1YzAgMS4wNDQtMS43MzUgMS43OS0xLjk1MiAyLjc1OC0uMjg5Ljk3Ljg2OCAyLjUzNS4zNjIgMy40My0uNTA2Ljg5NC0yLjMxNC42Ny0zLjAzNiAxLjQxNi0uNzIzLjc0NS0uNTA3IDIuNjEtMS4zNzQgMy4xMy0uODY3LjUyMy0yLjMxMy0uNTk1LTMuMzI1LS4zNzItLjk0LjIyNC0xLjY2MyAyLjAxMy0yLjY3NSAyLjAxMy0xLjAxMiAwLTEuNzM1LTEuNzktMi42NzUtMi4wMTMtLjk0LS4yOTgtMi40NTguODk1LTMuMzI1LjM3M3MtLjY1LTIuMzg2LTEuMzc0LTMuMTMxYy0uNzIyLS43NDYtMi41My0uNTIyLTMuMDM2LTEuNDE3LS41MDYtLjg5NC41NzktMi4zODUuMzYyLTMuNDI5QzEuNzM1IDE0LjE2NCAwIDEzLjQyIDAgMTIuMzc1czEuNzM1LTEuNzkgMS45NTItMi43NThjLjI4OS0uOTctLjg2OC0yLjUzNS0uMzYyLTMuNDMuNTA2LS44OTQgMi4zMTQtLjY3IDMuMDM2LTEuNDE2LjcyMy0uNzQ2LjUwNy0yLjYxIDEuMzc0LTMuMTMxLjg2Ny0uNTIyIDIuMzEzLjU5NiAzLjMyNS4zNzNDMTAuMjY1IDEuNzg5IDEwLjk4OCAwIDEyIDBjMS4wMTIgMCAxLjczNSAxLjc5IDIuNjc1IDIuMDEzLjk0LjI5OCAyLjQ1OC0uODk1IDMuMzI1LS4zNzMuODY4LjUyMi42NSAyLjM4NiAxLjM3NCAzLjEzMS43MjIuNzQ2IDIuNTMuNTIyIDMuMDM2IDEuNDE3LjUwNi44OTQtLjU3OSAyLjM4NS0uMzYyIDMuNDI5LjIxNy44OTQgMS45NTIgMS43MTQgMS45NTIgMi43NTh6Ii8+CiAgICAgICAgICAgIDxlbGxpcHNlIGN4PSIxMiIgY3k9IjEyLjM3NSIgZmlsbD0iI0ZGRiIgcng9IjgiIHJ5PSI4LjI1Ii8+CiAgICAgICAgPC9nPgogICAgICAgIDxnIGZpbGw9IiNCQTkxMTkiPgogICAgICAgICAgICA8cGF0aCBkPSJNOS4wNjIgMTEuNTEzbDUuMjE0IDYuMzU2LTIuMzY1LTYuMzU2ek0xMi4zNzYgMTEuNTEzbDIuNTIgNi43NzIgMi41NjgtNi43NzJ6TTE1LjQ1NyAxOC4wMzRsNS4zNDgtNi41MjFIMTcuOTN6TTE4Ljc2NSA4LjA4NGgtMy4zNzNsMi4zMTMgMi43OTV6TTE3LjMxMSAxMS4wODRMMTQuOTMzIDguMjFsLTIuMzc3IDIuODc0ek0xNC40NzUgOC4wODRIMTEuMWwxLjA0NyAyLjgxNHpNMTAuNzM3IDguMzU1TDkgMTEuMDg0aDIuNzUxek0yMC44NjcgMTEuMDg0TDE5LjEzIDguMzUybC0xLjAzNiAyLjczMnoiLz4KICAgICAgICA8L2c+CiAgICA8L2c+Cjwvc3ZnPgo=" alt="">
                        <?php } ?>
                    </div>
                  </div>
                  </div>

                </div>
              </div>
            </li>
            <?php } ?>
            <li class="gap"></li>
            <li class="gap"></li>
            <li class="gap"></li>
          </ul>
            <div class="controls-pagination">
            <div class="mixitup-page-list"></div>
            <div class="mixitup-page-stats"></div>
            </div>
           <p class="fail-message"><i class="las la-info-circle"></i> <strong><?=T::noresultsfound?></strong></p>
        </section>
      </div>
    </div>
  </div>
</section>

<script>
// remove dupicate contents
var seen = {};
$(".remove_duplication").find("li").each(function(index, html_obj) { txt = $(this).text().toLowerCase();
if(seen[txt]) { $(this).remove(); } else { seen[txt] = true; } });

// price range and filteration
var $rangeA = $('[data-ref="range-slider-a"]');
var $rangeB = $('[data-ref="range-slider-b"]');

$rangeA.ionRangeSlider({
    skin: "round",
    type: "double",
    min: <?php foreach ($tours_data as $index => $item) {$result[$index] = $item->b2c_price;} echo $min_price = min($result); ?>,
    max: <?php foreach ($tours_data as $index => $item) {$result[$index] = $item->b2c_price;} echo $min_price = max($result); ?>,
    from: <?php foreach ($tours_data as $index => $item) {$result[$index] = $item->b2c_price;} echo $min_price = min($result); ?>,
    to: <?php foreach ($tours_data as $index => $item) {$result[$index] = $item->b2c_price;} echo $min_price = max($result); ?>,
    onChange: handleRangeInputChange
});

$rangeB.ionRangeSlider({
    skin: "round",
    type: "double",
    min: 0,
    max: 10,
    from: 0,
    to: 10,
    onChange: handleRangeInputChange
});

var instanceA = $rangeA.data("ionRangeSlider");
var instanceB = $rangeB.data("ionRangeSlider");

var container = document.querySelector('[data-ref="container"]');
var mixer = mixitup(container, {
    animation: { duration: 350, queueLimit: 10, effectsIn: 'fade translateY(-100%)' },
    pagination: { limit: 25 },
    multifilter: { enable: true  },
    callbacks: {
    onMixStart: function(){ $('.fail-message').fadeOut(0); $('.controls-pagination').css('display','block'); },
    onMixFail: function(){ $('.fail-message').fadeIn(0); $('.controls-pagination').css('display','none'); },
    onMixEnd: function(state) { paginationCallback();  }
    },
});

// to scroll up on data content
function paginationCallback() { $("body,html").animate({ scrollTop: $("#data").offset().top - 80  }, 10); }

function getRange() {
    var aMin = Number(instanceA.result.from);
    var aMax = Number(instanceA.result.to);
    var bMin = Number(instanceB.result.from);
    var bMax = Number(instanceB.result.to);
    return {
        aMin: aMin,
        aMax: aMax,
        bMin: bMin,
        bMax: bMax,
    };
}

function handleRangeInputChange() {
    mixer.filter(mixer.getState().activeFilter);
}

function filterTestResult(result, target) {
    var a = Number(target.dom.el.getAttribute('data-a'));
    var b = Number(target.dom.el.getAttribute('data-b'));
    var range = getRange();

    console.log(range);

    if (a < range.aMin || a > range.aMax || b < range.bMin || b > range.bMax) {
        result = false;
    }
    return result;
}

mixitup.Mixer.registerFilter('testResultEvaluateHideShow', 'range', filterTestResult);

/*
fetch('https://yasen.hotellook.com/autocomplete?term=lahore')
    .then(response => {
        // handle the response
        console.log(response->cities)
    })
    .catch(error => {
        // handle the error
    });

let citylonglat = fetch('');
*/
</script>
<?php } ?>