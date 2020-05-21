<?php
 class  Mes_Ano    {
     var  $meses   =   array('01','02','03','04','05','06','07','08','09','10','11','12');
     
     function anoatu() {
        $anoatu  =   date('Y'); 
        return $anoatu;
     }
     function mesatu() {
        $mesatu  =   date('m'); 
        return $mesatu;
     }
     function anos() {  // do ano corrente até 5 anos anteriores
         $anos     =   array($this->anoatu(),($this->anoatu() - 1),($this->anoatu() - 2),($this->anoatu() - 3),($this->anoatu() - 4),($this->anoatu() - 5));
         return $anos;
     }
     
     public function pega_um_mes() {
// select do mes inicial    
       //            if ($this->meses[$x] == $this->mesatu()) {
       //               $lista_data .= '<OPTION   SELECTED VALUE="'.$this->meses[$x].'">'.$this->meses[$x].'</OPTION>';
       //         } else { $lista_data .= '<OPTION  VALUE="'.$this->meses[$x].'">'.$this->meses[$x].'</OPTION>'; }
       
            $anos = $this->anos();
            $lista_data = '<SELECT NAME="MesIni" SIZE="1" class="f_field_t">
                                       <OPTION   SELECTED VALUE="" ></OPTION>'; 
            for ($x = 0; $x < count($this->meses); $x++)  {
                  $lista_data .= '<OPTION  VALUE="'.$this->meses[$x].'">'.$this->meses[$x].'</OPTION>'; 
            }
            $lista_data .= '</SELECT>';
//select do ano inicial      
           $lista_data .= '<SELECT NAME="AnoIni" SIZE="1" class="f_field_t">';
             for ($x = 0; $x < count($anos); $x++)  {
                 if ($anos[$x] == $this->anoatu()) {
                    $lista_data .= '<OPTION   SELECTED VALUE="'.$anos[$x].'">'.$anos[$x].'</OPTION>';
                 } else { $lista_data .= '<OPTION  VALUE="'.$anos[$x].'">'.$anos[$x].'</OPTION>'; }
            }
            $lista_data .= '</SELECT>';
            return $lista_data;  
    }

     
     public function pega_meses() {
// select do mes inicial    
     $anos = $this->anos();
     $lista_data = '<SELECT NAME="MesIni" SIZE="1" class="f_field_t">';
     for ($x = 0; $x < count($this->meses); $x++)  {
        if ($this->meses[$x] == $this->mesatu()) {
        $lista_data .= '<OPTION   SELECTED VALUE="'.$this->meses[$x].'">'.$this->meses[$x].'</OPTION>';
        } else { $lista_data .= '<OPTION  VALUE="'.$this->meses[$x].'">'.$this->meses[$x].'</OPTION>'; }
     }
     $lista_data .= '</SELECT>';
//select do ano inicial      
     $lista_data .= '<SELECT NAME="AnoIni" SIZE="1" class="f_field_t">';
     for ($x = 0; $x < count($anos); $x++)  {
        if ($anos[$x] == $this->anoatu()) {
            $lista_data .= '<OPTION   SELECTED VALUE="'.$anos[$x].'">'.$anos[$x].'</OPTION>';
        } else { $lista_data .= '<OPTION  VALUE="'.$anos[$x].'">'.$anos[$x].'</OPTION>'; }
     }
     $lista_data .= '</SELECT><B class="f_label2">&nbsp;&nbsp;a&nbsp;&nbsp;</B>';
// selecto do periodo final
     $lista_data .= '<SELECT NAME="MesFim" SIZE="1" class="f_field_t">';
     for ($x = 0; $x < count($this->meses); $x++)  {
        if ($this->meses[$x] == $this->mesatu()) {
        $lista_data .= '<OPTION   SELECTED VALUE="'.$this->meses[$x].'">'.$this->meses[$x].'</OPTION>';
        } else { $lista_data .= '<OPTION  VALUE="'.$this->meses[$x].'">'.$this->meses[$x].'</OPTION>'; }
     }
     $lista_data .= '</SELECT>';
     $lista_data .= '<SELECT NAME="AnoFim" SIZE="1" class="f_field_t">';
     for ($x = 0; $x < count($anos); $x++)  {
        if ($anos[$x] == $this->anoatu()) {
        $lista_data .= '<OPTION   SELECTED VALUE="'.$anos[$x].'">'.$anos[$x].'</OPTION>';
        } else { $lista_data .= '<OPTION  VALUE="'.$anos[$x].'">'.$anos[$x].'</OPTION>'; }
     }
     $lista_data .= '</SELECT>';
     return $lista_data;  
   }
}
// $sessao = new Session;
// $sessao->set('TESTE_JOAO','Aqui');
// echo $sessao->get('login_usuario');
?>
