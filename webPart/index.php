<?php

session_start();
include ('include/config.php');

?>

<!DOCTYPE html>
<html>
<head>
    <title>Accueil</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta charset="UTF-8">
</head>


<body>

<?php include('include/new_header.php'); ?>


<main>
  <div id="threejs">

    <div id="blocker">

      <h2 class="ml6">
        <span class="text-wrapper">
          <span class="letters"></span>
        </span>
      </h2>
      <h2 class="ml7">
        <span class="text-wrapper">
          <span class="letters 2"></span>
        </span>
      </h2>
      <h2 class="ml75">
        <span class="text-wrapper">
          <span class="letters 2"></span>
        </span>
      </h2>
      <h2 class="ml2"></h2>

      <center><a href="inscription.php">
      <h2 class="ml15">
        <span class="word"></span>
        <span class="word"></span>
      </h2>
      </a>
    </center>

    </div>

	</div>
</main>
<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
<script type="module">

      //threejs

			import * as THREE from './webgl/js/three.module.js';

			import { OrbitControls } from './webgl/js/OrbitControls.js';

      import { GLTFLoader } from './webgl/js/GLTFLoader.js';

			var camera, controls, scene, renderer, rooms, kid, mixer, clock;

			init();
			//render(); // remove when using next line for animation loop (requestAnimationFrame)
			animate();

			function init() {

        clock = new THREE.Clock();
				scene = new THREE.Scene();
				scene.background = new THREE.Color( 0xcccccc );
				scene.fog = new THREE.FogExp2( 0xcccccc, 0.002 );

				renderer = new THREE.WebGLRenderer( { antialias: true } );
				renderer.setPixelRatio( window.devicePixelRatio );
				renderer.setSize( window.innerWidth-18, window.innerHeight-70 );
				document.getElementById('threejs').appendChild( renderer.domElement );

				camera = new THREE.PerspectiveCamera( 60, window.innerWidth / window.innerHeight, 1, 1000 );
				camera.position.set( -30, 43, 39 );
        camera.lookAt(2,32,0);

				/* controls

				controls = new OrbitControls( camera, renderer.domElement );

				//controls.addEventListener( 'change', render ); // call this only in static scenes (i.e., if there is no animation loop)

				controls.enableDamping = true; // an animation loop is required when either damping or auto-rotation are enabled
				controls.dampingFactor = 0.05;

				controls.screenSpacePanning = false;

				controls.minDistance = 100;
				controls.maxDistance = 500;

				controls.maxPolarAngle = Math.PI / 2; */

				// world

				var geometry = new THREE.CylinderBufferGeometry( 0, 10, 30, 4, 1 );
				var material = new THREE.MeshPhongMaterial( { color: 0xffffff, flatShading: true } );

				// lights

				var light = new THREE.DirectionalLight( 0xffffff );
				light.position.set( 1, 1, 1 );
				scene.add( light );

				var light = new THREE.DirectionalLight( 0x002288 );
				light.position.set( - 1, - 1, - 1 );
				scene.add( light );

				var light = new THREE.AmbientLight( 0x222222 );
				scene.add( light );

				//rooms

        var loader = new GLTFLoader();
        loader.load( 'webgl/rooms/scene.gltf', function (gltf) {
           rooms = gltf.scene;
           scene.add( rooms );
           rooms.scale.set(20,20,20);
           rooms.position.set(0,20,0);
        });

        //kid

        loader.load( 'webgl/low_poly_kid/scene.gltf', function ( gltf ) {

          var model = gltf.scene;
          var animations = gltf.animations;
          model.scale.set(0.025,0.025,0.025);
          model.position.set(-25,20,13);

          scene.add( model );

          mixer = new THREE.AnimationMixer( model );

          var action = mixer.clipAction( animations[ 0 ] ); // access first animation clip
          action.play();

        } );

				window.addEventListener( 'resize', onWindowResize, false );

			}

			function onWindowResize() {

				camera.aspect = window.innerWidth / window.innerHeight;
				camera.updateProjectionMatrix();

				renderer.setSize( window.innerWidth, window.innerHeight );

			}

			function animate() {

				requestAnimationFrame( animate );

				//controls.update(); // only required if controls.enableDamping = true, or if controls.autoRotate = true

        //mixer.update();
        var delta = clock.getDelta(); // clock is an instance of THREE.Clock
        if ( mixer ) mixer.update( delta );

				render();

			}

			function render() {

				renderer.render( scene, camera );

			}

      //animation text

      setTimeout(function(){
      // Wrap every letter in a span
      var textWrapper = document.querySelector('.ml6 .letters');
      textWrapper.innerHTML = "Besoin d'un babysitter ?";
      textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");

      anime.timeline({loop: false})
      .add({
        targets: '.ml6 .letter',
        translateY: ["1.1em", 0],
        translateZ: 0,
        duration: 750,
        delay: (el, i) => 50 * i
      });
    }, 3000);


    setTimeout(function(){
    // Wrap every letter in a span
    var textWrapper = document.querySelector('.ml7 .letters');
    textWrapper.innerHTML = "Besoin d'un cuisinier ?";
    textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");

    anime.timeline({loop: false})
    .add({
      targets: '.ml7 .letter',
      translateY: ["1.1em", 0],
      translateZ: 0,
      duration: 750,
      delay: (el, i) => 50 * i
    });
  }, 5000);

  setTimeout(function(){
  // Wrap every letter in a span
  var textWrapper = document.querySelector('.ml75 .letters');
  textWrapper.innerHTML = "Besoin d'un plombier ?";
  textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");

  anime.timeline({loop: false})
  .add({
    targets: '.ml75 .letter',
    translateY: ["1.1em", 0],
    translateZ: 0,
    duration: 750,
    delay: (el, i) => 50 * i
  });
}, 7000);


       setTimeout(function(){
      // Wrap every letter in a span
      var textWrapper = document.querySelector('.ml2');
      textWrapper.innerHTML = "Choisissez parmis des centaines de services sur BringMe.com !";
      textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");

      anime.timeline({loop: false})
      .add({
        targets: '.ml2 .letter',
        scale: [4,1],
        opacity: [0,1],
        translateZ: 0,
        easing: "easeOutExpo",
        duration: 950,
        delay: (el, i) => 70*i
      });
    }, 10000);

    setTimeout(function(){
      document.querySelectorAll(".word")[0].innerHTML = "S'inscrire";
      document.querySelectorAll(".word")[1].innerHTML = "Dès maintenant";
      anime.timeline({loop: false})
      .add({
        targets: '.ml15 .word',
        scale: [14,1],
        opacity: [0,1],
        easing: "easeOutCirc",
        duration: 800,
        delay: (el, i) => 800 * i
      });
    }, 15000);

		</script>
    <?php include('include/new_footer.php'); ?>
    </body>
</html>
