/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


yiff = new function() {
    
    this.url = function(params) {
        url = '/';
        if (! params) {
            return document.location;
        }
        url+= params.controller;
    }
    
    this.a = function() {
        alert('b');
    };
};