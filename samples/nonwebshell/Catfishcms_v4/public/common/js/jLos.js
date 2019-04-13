/**
 * Project: jLos
 * Description: 浏览器本地存储
 * Author: A.J <804644245@qq.com>
 * Copyright: http://www.catfish-cms.com All rights reserved.
 * Version: 1.1.0
 */
(function ($){
	var availableLocalStorage = 0;
	function jLos(){
		this.isValid = false;
		this.expire = 0;
	}
	jLos.prototype = {
		open : function(expire){
			this.expire = expire || 0;
			availableLocalStorage = isValidLocalStorage();
			if(availableLocalStorage > 0){
				this.isValid = true;
			}
			else{
				this.isValid = false;
			}
			return this;
		},
		getSize : function(){
			return availableLocalStorage;
		},
		get : function(key){
			if(this.isValid){
				return getStorage(key);
			}
			else{
				return '';
			}
		},
		set : function(key, value, expire){
			expire = expire || this.expire;
			if(this.isValid){
				return setStorage(key, value, expire);
			}
			else{
				return false;
			}
		},
		remove : function(key){
			if(this.isValid){
				return removeStorage(key);
			}
			else{
				return false;
			}
		},
		clear : function(){
			if(this.isValid){
				return clearStorage();
			}
			else{
				return false;
			}
		},
		getNumber : function(){
			if(this.isValid){
				return $.localStorage.length;
			}
			else{
				return 0;
			}
		},
		getKeys : function(){
			var keyArr = [];
			if(this.isValid){
				for (var i = 0; i < $.localStorage.length; i++) {
					keyArr.push($.localStorage.key(i));
				}
			}
			return keyArr;
		}
	};
	if(!$.jLos){
		$.jLos = new jLos;
	}
	function remainingSpace(){
		var onek = 'a';
		while(onek.length < 1024){
			onek += 'a';
		}
		var wr = false, rp = 0, totalk = onek;
		while(wr == false){
			try{
				$.localStorage.setItem('jds_test_key', onek);
				totalk += onek;
				rp ++;
			}
			catch(e){
				wr = true;
				$.localStorage.removeItem('jds_test_key');
				onek = null;
				totalk = null;
				return rp * 1024;
			}
		}
	}
	function isValidLocalStorage(){
		if($.localStorage){
			try{
				$.localStorage.setItem('jds_test_key', 'jds_test_value');
				if($.localStorage.getItem('jds_test_key') == 'jds_test_value'){
					return remainingSpace();
				}
				else{
					return 0;
				}
			}
			catch(e){
				return 0;
			}
		}
		else{
			return 0;
		}
	}
	function setStorage(key, value, expire){
		var ep = 0;
		if(expire > 0){
			var dt = new Date();
			ep = dt.getTime() + (expire * 1000);
		}
		var storage = {
			expire : ep,
			data : value
		};
		var sdata = JSON.stringify(storage);
		var slen = key.length + sdata.length;
		if(availableLocalStorage > slen){
			try{
				$.localStorage.setItem(key, sdata);
				availableLocalStorage -= slen;
			}catch(e){
				return false;
			}
			return true;
		}
		else{
			return false;
		}
	}
	function getStorage(key){
		var dt = new Date(), data = '', getData, dataObj;
		try{
			getData = $.localStorage.getItem(key);
			if(getData != null){
				dataObj = JSON.parse(getData);
			}
			else{
				return data;
			}
		}catch(e){
			return data;
		}
		if(dataObj.expire == 0 || dataObj.expire >= dt.getTime()){
			data = dataObj.data;
		}
		else{
			try{
				$.localStorage.removeItem(key);
				availableLocalStorage += key.length + getData.length;
			}catch(e){
				return data;
			}
		}
		return data;
	}
	function removeStorage(key){
		try{
			var getData = $.localStorage.getItem(key);
			if(getData != null){
				$.localStorage.removeItem(key);
				availableLocalStorage += key.length + getData.length;
			}
			return true;
		}catch(e){
			return false;
		}
	}
	function clearStorage(){
		try{
			$.localStorage.clear();
			availableLocalStorage = remainingSpace();
			return true;
		}catch(e){
			return false;
		}
	}
})(window);