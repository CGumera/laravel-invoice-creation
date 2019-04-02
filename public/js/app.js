/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  $('#add_product').click(function () {
    var index = $('#tbl_products tbody tr').length + 1;
    var row = $('#prod-1').html().replace(/-1/g, '-' + index).replace('d-none', 'd-block');
    $('#tbl_products').append('<tr id="prod-' + index + '"></tr>');
    $('#prod-' + index).html(row).find('td:first-child').html(index);
    resetValues(index);
  });
  $('.btn-delete-product').on('click', deleteProductRow);
  $('#add_payment_type').click(function () {
    var index = $('#tbl_payment_type tbody tr').length + 1;
    var row = $('#ptype-1').html().replace(/-1/g, '-' + index).replace('d-none', 'd-block');
    ;
    $('#tbl_payment_type').append('<tr id="ptype-' + index + '"></tr>');
    $('#ptype-' + index).html(row).find('td:first-child').html(index);
    $('#payment_type-' + index).val('');
    $('#amount-' + index).val('');
    $('#delete_payment_type-' + index).on('click', deletePtypeRow);
  });
  $('.btn-delete-ptype').on('click', deletePtypeRow);
  $('#product-1').on('change', getProductDetails);
  $('.quantity, .unit_price').on('keyup change', calcTotalPrice);
  $('#tax_percent').on('keyup change', calcGrandTotal);
});

function getProductDetails() {
  var idArr = this.id.split('-');
  jQuery.ajax({
    url: '/product/' + $('#product-' + idArr[1]).val(),
    method: 'get',
    success: function success(result) {
      $('#quantity-' + idArr[1]).val(1);
      $('#unit_price-' + idArr[1]).val(result.price);
      calcTotalPrice();
    }
  });
}

function calcTotalPrice() {
  $('#tbl_products tbody tr').each(function (i, element) {
    var quantity = $(this).find('.quantity').val();
    var unit_price = $(this).find('.unit_price').val();
    var total_price = quantity * unit_price;
    $(this).find('.total_price').val(total_price.toFixed(2));
    calcGrandTotal();
  });
}

function resetValues(index) {
  $('#product-' + index).val('');
  $('#quantity-' + index).val('');
  $('#unit_price-' + index).val('');
  $('#product-' + index).on('change', getProductDetails);
  $('#delete_product-' + index).on('click', deleteProductRow);
  $('.quantity, .unit_price').on('keyup change', calcTotalPrice);
  calcTotalPrice();
}

function deleteProductRow() {
  var idArr = this.id.split('-');
  $("#prod-" + idArr[1]).remove();
  $('#tbl_products tbody tr').each(function (i) {
    $(this).find('td:first-child').html(i + 1);
  });
  calcTotalPrice();
}

function deletePtypeRow() {
  var idArr = this.id.split('-');
  $("#ptype-" + idArr[1]).remove();
  $('#tbl_payment_type tbody tr').each(function (i) {
    $(this).find('td:first-child').html(i + 1);
  });
}

function calcGrandTotal() {
  var total = 0;
  $('.total_price').each(function () {
    total += parseInt($(this).val());
  });
  $('#sub_total').val(total.toFixed(2));
  var tax_amount = total / 100 * $('#tax_percent').val();
  $('#tax_amount').val(tax_amount.toFixed(2));
  $('#grand_total').val((tax_amount + total).toFixed(2));
}

/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!*************************************************************!*\
  !*** multi ./resources/js/app.js ./resources/sass/app.scss ***!
  \*************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! F:\Programming\Repo\laravel\invoice-creation\resources\js\app.js */"./resources/js/app.js");
module.exports = __webpack_require__(/*! F:\Programming\Repo\laravel\invoice-creation\resources\sass\app.scss */"./resources/sass/app.scss");


/***/ })

/******/ });