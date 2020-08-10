let socket;

const sendSocketMessage=()=>{
	socket.send( 'test mesage...' );
}

const startSocket=()=>{
	var data = {
		action: 'socket_test'
	};

	self = this;

	axios.post( '/wp-admin/admin-ajax.php', Qs.stringify( data ) )
	.then( response => {
		
		console.log(data);

		/*socket  = new WebSocket('ws://localhost:8080');

		socket.onmessage = function(e) {
		    alert( e.data );
		}*/

	})
	.catch( error => console.log( error ) );
}


document.addEventListener('DOMContentLoaded',()=>{

	startSocket();

});