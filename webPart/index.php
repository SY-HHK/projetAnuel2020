<?php
include('include/lang.php');
session_start();
include ('include/config.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $lang['title']; ?></title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Baloo+Thambi+2:600|Roboto&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
</head>

<body>

<?php include('include/new_header.php'); ?>


<main>
  <div id="threejs">

    <div id="blocker">

      <h2><?php echo $lang['question1'];?></h2>
      <p><?php echo $lang['hook'];?></p>
      <a class="waves-effect waves-light btn-large" href="login/inscription.php"><?php echo $lang['buttonIndex'];?></a>

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

		</script>
   
    </body>
     <?php include('include/new_footer.php'); ?>

