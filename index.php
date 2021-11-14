<html>
  <head>
    <title>Desafio</title>
    <link href="bootstrap.css" rel="stylesheet"/>
  </head>
  <body class="bg-dark text-light">
    <div class="container">
      <?php
        if(isset($_GET['cases']) && isset($_GET['1-1'])) {

          echo "<br><h3>Resultado</h3>";

          for($l=0; $l<$_GET['cases']; $l++) {
            //Limpando os array's a cada volta no laço
            unset($array1);
            unset($array2);
            //Preenchendo array de blocos
            for($i=0; $i<$_GET['cols-'.($l+1)]; $i++) {
              $array1[] = $_GET[($l+1).'-'.($i+1)];
            }

            //Pegando o maior valor do array de blocos
            $bigger = $array1[0];
            for ($i=1; $i<count($array1); $i++) {
              if ($array1[$i]>$bigger) {
                $bigger = $array1[$i];
              }
            }

            //Preenchendo todo o segundo array com água, no espaço que resta do primeiro array
            for ($i=0; $i<count($array1); $i++) {
              $array2[] = $bigger - $array1[$i];
            }

            //Percorrendo níveis, de cima para baixo
            for($i=$bigger; $i>0; $i--) {
              $count = 0; //Contador de ocorrências em que um bloco é encontrado na linha
              $firstPos = null; //Variável para guardar a primeira ocorrência de bloco na linha
              $lastPos = null; //Variável para guardar a última ocorrência de bloco na linha

              //Percorrendo array de blocos
              for($j=0; $j<count($array1); $j++) {
                if($array1[$j]>=$i) { //Testando se existe ocorrência de um bloco em cada posição percorrida
                  $count++; //Contando ocorrências
                  if($firstPos===null) { //Testando se é a primeira ocorrência
                    $firstPos = $j; //Primeira posição de ocorrência recebe a posição atual
                    $lastPos = $j; //Última posição de ocorrência recebe a posição atual
                  } else if($j>$lastPos) { //Se não for a primeira ocorrência, testar se posição de ocorrência atual é maior que a última posição
                    $lastPos = $j; //Se for maior, a última posição passa a ser a posição atual
                  }
                }
              }

              //Após descobrir primeira e última ocorrência de blocos na linha atual, percorrer arrays novamente
              for ($k=0; $k<count($array1); $k++) {
                if($array2[$k]!=0) { //Caso tenha algum nível de água no bloco atual...
                  if($count<=1) { //Testar se houve no máximo uma ocorrência de bloco
                    $array2[$k]--; //Diminui um nível de água em todas as posições (exceto na posição de ocorrência)
                  } else if($count>=2) { //Testar se houve duas ou mais ocorrências de blocos
                    if($k<$firstPos || $k>$lastPos) { //Se a posição atual for menor que a primeira posição de ocorrência, ou maior que a última...
                      $array2[$k]--; //Diminui um nível de água
                    }
                  }
                }
              }
            }

            //Imprimindo resultado na tela
            echo "<br><h5>" . ($l+1) . "º caso</h5><b>Blocos: ";
            for ($i=0; $i<count($array1); $i++) {
              echo $array1[$i] . " ";
            }
            echo "<br>Água: ";
            $sum = 0;
            for ($i=0; $i<count($array1); $i++) {
              echo $array2[$i] . " ";
              $sum+=$array2[$i];
            }
            echo "<br>Qntd. d'água: " . $sum . "</b><br>";
          }
        }

      ?>

      <br><br><br>
      <h3>Desafio</h3>
      <br>
      <div class="row">
        <?php if(!isset($_GET['cases'])): ?>
          <h4>Fase 1</h4>
          <form method="GET" action="index.php">
            <div class="col-md-2">
              <label class="form-label">Quantos casos?</label>
              <input class="form-control" type="number" name="cases" min="1" max="100" value="1" required/>
            </div>
            <br>
            <input class="btn btn-success" type="submit" value="Gerar casos"/>
          </form>
        <?php endif; ?>
        <?php if(isset($_GET['cases']) && !isset($_GET['cols-1'])): ?>
          <h4>Fase 2</h4>
          <form method="GET" action="index.php">
            <input type="hidden" name="cases" value="<?php echo $_GET['cases']; ?>"/>
            <div class="row">
              <?php for($i=0; $i<$_GET['cases']; $i++): ?>
                <div class="col-md-3">
                  <label class="form-label">Quantas colunas no <?php echo $i+1; ?>º caso?</label>
                  <input class="form-control" type="number" name="cols-<?php echo $i+1; ?>" min="1" max="100" value="1" required/>
                </div>
              <?php endfor; ?>
            </div>
            <br>
            <input class="btn btn-success" type="submit" value="Gerar colunas para cada caso"/>
          </form>
        <?php endif; ?>
        <?php if(isset($_GET['cases']) && isset($_GET['cols-1'])): ?>
          <h4>Fase 3</h4>
          <form method="GET" action="index.php">
            <input type="hidden" name="cases" value="<?php echo $_GET['cases']; ?>"/>
            <?php for($i=1; $i<=$_GET['cases']; $i++): ?>
              <input type="hidden" name="cols-<?php echo $i; ?>" value="<?php echo $_GET['cols-' . $i]; ?>"/>
              <h4><?php echo $i; ?>º caso</h4>
              <div class="row">
                <?php for($j=0; $j<$_GET['cols-'.$i]; $j++): ?>
                  <div class="col-sm-2">
                    <label class="form-label"><?php echo $j+1; ?>ª coluna</label>
                    <input class="form-control" type="text" name="<?php echo ($i) . '-' . ($j+1); ?>" min="1" max="100" value="1" required/>
                  </div>
                <?php endfor; ?>
              </div>
              <?php echo "<br><br>" ?>
            <?php endfor; ?>
            <br>
            <input class="btn btn-success" type="submit" value="Gerar resultado" style="margin-right: 10px;"/>
            <?php if(isset($_GET['cases']) && isset($_GET['1-1'])) { ?>
              <a class="btn btn-danger" href="index.php">Recomeçar</a>
            <?php } ?>
          </form>
        <?php endif; ?>
      </div>
    </div>
  </body>
</html>
