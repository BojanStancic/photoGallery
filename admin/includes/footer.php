  </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>


    <!-- WYSIWYG text editor (included in edit_photo.php)-->
    <!-- <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script> --> <!-- bez api kljuca -->
    <script src="https://cdn.tiny.cloud/1/6dgty8e3hwfbi5bjf86bj0nlqkch8274r8zjqnhoq7yytedd/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script> <!-- sa api kljucem (registrovao sam se na sajt) -->

    <script type="text/javascript" src="js/dropzone.js"></script>
    
    <script type="text/javascript" src="js/scripts.js"></script>


    <script type="text/javascript">

    // peuzeto(prkopirano) sa https://developers.google.com/chart/interactive/docs/gallery/piechart (besplatno je)
      google.charts.load('current', {'packages':['corechart']});   
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Views',     <?php echo $session->count; ?>],
          ['Comments', <?php echo Comment::count_all(); ?>],
          ['Users',  <?php echo User::count_all(); ?>],
          ['Photo',      <?php echo Photo::count_all(); ?>]
        ]);

        var options = {
          legend: 'none',	
          pieSliceText: 'label',	
          title: 'My Daily Activities',
          backgroundColor: 'transparent'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
  

</body>

</html>
