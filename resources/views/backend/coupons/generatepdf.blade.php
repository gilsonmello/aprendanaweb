<br>
<p style="font-family: Verdana; font-size: 18px; text-align: right">NÚMERO: {{$coupon['Coupon']->id}}</p>
<br>
<br>
<br>
<br>
<br>
<table cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td>
            <p style="font-family: Verdana; font-size: 18px; text-align: center">AUTORIZAÇÃO DE CUPOM</p>
        </td>
    </tr>
    <tr align="left">
        <td align="left"><?php if(isset($coupon['Course'])) : ?><label style="line-height: 1.6; font-family: Verdana; font-size: 15px;"><br><br><strong>Curso(s).:</strong>
                <?php
                $i = 1;
                foreach($coupon['Course'] as $courses):
                    if(count($coupon['Course']) == $i)
                        echo $courses->title;
                    else
                        echo $courses->title.', ';
                    $i++;
                endforeach;
                ?>
            </label>
            <?php endif; ?><?php if(isset($coupon['User'])) : ?><label style="line-height: 1.6; font-family: Verdana; font-size: 15px;"><br><strong>Aluno(s).:</strong>
                <?php
                $i = 1;
                foreach($coupon['User'] as $users):
                    if(count($coupon['User']) == $i)
                        echo ucwords(strtolower($users->name));
                    else
                        echo ucwords(strtolower($users->name)).', ';
                    $i++;
                endforeach;
                ?></label>
            <?php endif; ?><label style="line-height: 1.6; font-family: Verdana; font-size: 15px;"><br><strong>Código:</strong> {{$coupon['Coupon']->code}}</label>
            <label style="line-height: 1.6; font-family: Verdana; font-size: 15px;"><br><strong>Validade.: </strong><?php echo implode('/', array_reverse(explode('-', $coupon['Coupon']->due_date))).' 23:59:59';?></label>
            <label style="line-height: 1.6; font-family: Verdana; font-size: 15px;"><br><?php if(isset($coupon['Coupon']->percentage) && $coupon['Coupon']->percentage > 0 ) : ?><?php if($coupon['Coupon']->percentage == 100.0000) echo "<strong>Bolsa Integral</strong>"; else echo "<strong>Porcentagem.: </strong>".(int)$coupon['Coupon']->percentage."%"; ?>
                <?php elseif(isset($coupon['Coupon']->value) && $coupon['Coupon']->value > 0): ?><strong>Valor em dinheiro.: </strong>R$ <?php echo number_format($coupon['Coupon']->value, 2, ',', '.');?>
                <?php endif; ?>
                </label><?php if(!empty($coupon['Coupon']->description)): ?><label style="line-height: 1.6; font-family: Verdana; font-size: 15px;"><br><br><?php echo strip_tags ($coupon['Coupon']->description);?>
            </label><?php endif;?>
            <label style="font-family: Verdana; font-size: 15px;"><br><br><br><br>Salvador, <?php setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
                date_default_timezone_set('America/Sao_Paulo');
                $date = date('Y-m-d');
                echo strftime('%d', strtotime($date)).' de '. month_year_br($date, false).'.';
                ?>
            </label>
            <br><br><br><br><label style="font-family: Verdana; font-size: 15px;">__________________________________<br>&nbsp;Francisco Fontenele
            </label>
            <p>&nbsp;</p>
            <p>&nbsp;</p><label style="font-family: Verdana; font-size: 15px;">&nbsp;De acordo.:<br>__________________________________
            </label>
        </td>
    </tr>
</table>

