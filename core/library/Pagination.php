<?php


    namespace library;


    use library\Filter;
    use library\Url;

    class Pagination
    {

        private $pagination = [];
        private $back;
        private $ahead;
        private $choicePage;
        private $url;

        public function __construct( $get, $count, $cumSee,  $url = null)
        {
            if(is_null($url)) $this->url = $_GET['url'];
            else  $this->url = $url;
            $get = Filter::sanINT($get);
            $count = Filter::sanINT($count);
            $cumSee = Filter::sanINT($cumSee);
            if ($count != 0 && $count > $cumSee){
                 $this->generatePagination($get, $count, $cumSee);
                 $this->view();
            }


        }

        private function generatePagination($get, $count, $cumSee){
            $a = ceil($get / $cumSee);
            $sliseA = $a - 5;
            $s = $count / $cumSee;
            $s = ceil($s);
            $b = $a + 6;
            if ($b <= 10 ) $sliseB = $b;
            if ($a+1 > 5 && $a+1 < ($s - 5)) $sliseB = 11;
            if ($a+1 >= ($s - 5)) $sliseB = $a + 5;
            if (0 > $sliseA) $sliseA = 0;
            for ($i = 1; $i <= $s; $i ++) {
                $key = $i*$cumSee - $cumSee;
                $numScroll[] = [$key => $i];
            }
            $numScroll = array_slice($numScroll, $sliseA, $sliseB);
            foreach ($numScroll as $numScrolls) {
                foreach ($numScrolls as $key => $value) {
                    $this->pagination[$key] = $value;
                }
            }
            $this->choicePage = $a + 1;
            if ($get != 0) $this->back = $get - $cumSee;
            if ($s != $a + 1) $this->ahead = $get + $cumSee;
        }

        private function view(){
            if (empty($this->pagination)) return;?>
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item">
                        <?php if (!is_null($this->back)): ?>
                            <a class="page-link" href="<?= $this->changeGet( $this->url ,'view', $this->back)?>">назад</a>
                        <?php endif; ?>
                    </li>
                        <?php foreach ($this->pagination as $key => $value):?>
                    <li class="page-item">
                            <?php if ($this->choicePage == $value): ?>
                                <span class="page-link" style='color: rgb(123, 122, 122);'><?=$value?></span>
                            <?php else: ?>
                                <a class="page-link" href="<?= $this->changeGet($this->url,'view', $key)?>"><?=$value?></a>
                            <?php endif; ?>
                    </li>
                        <?php endforeach; ?>
                    <li class="page-item">
                        <?php if (!is_null($this->ahead)): ?>
                            <a class="page-link" href="<?= $this->changeGet($this->url,'view', $this->ahead)?>">вперед</a>
                        <?php endif; ?>
                    </li>
                </ul>
            </nav>
            <?php
        }

        private function changeGet ($url ,$get, $val) {
            $url = '/'.$url.'?';
            foreach ($_GET as $key => $value) {
                if ($key == 'url') continue;
                if ($key == $get) {
                    $url .= "&".$get."=".$val;
                    continue;
                }
                $url .= "&".$key."=".$value;
            }
            if (!array_key_exists($get, $_GET)) $url .= "&".$get."=".$val;
            return $url;
        }

    }