importScripts('https://www.gstatic.com/firebasejs/8.9.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.9.1/firebase-messaging.js');
   
	firebase.initializeApp({
        apiKey: "AIzaSyBKBPjpnddl5AfnxQgtWuTP-KKhlNsq2vI",
	    authDomain: "office-coffee-f4475.firebaseapp.com",
	    databaseURL: "https://office-coffee-f4475.firebaseio.com",
	    projectId: "office-coffee-f4475",
        messagingSenderId:"496766642306",
	    storageBucket: "office-coffee-f4475.appspot.com",
	    messagingSenderId: "496766642306",	    
	    appId: "1:496766642306:web:0e364d126d801b8c362c9b",
        measurementId: "G-2T61HGFD2Q"
    });

	const messaging = firebase.messaging();
	messaging.setBackgroundMessageHandler(function(payload) {
    console.log(
        "[firebase-messaging-sw.js] Received background message ",
        payload,
    );
        
    const notificationTitle = "Background Message Title";
    const notificationOptions = {
        body: "Background Message body.",
        icon: "/itwonders-web-logo.png",
    };
  
    return self.registration.showNotification(
        notificationTitle,
        notificationOptions,
    );
});