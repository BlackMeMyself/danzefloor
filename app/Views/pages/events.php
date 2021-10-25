<div class="imagenfondo">
    <div class="comingUp">
        <div class="encabEv">
            <h4 class="evplace">PLACE</h4>
            <h4 class="evtime">TIME</h4>
        </div>
        <?php $i = 0;
        foreach ($events as $event) {
            $i++ ?>
            <div class="comingUpInfo <?php if ($i % 2 == 0) {
                                            echo "proxEvent";
                                        } ?>">
                <div><?php echo $event["place"] ?> </div>
                <div><?php echo $event["time"] ?> </div>
            </div>
        <?php } ?>
    </div>
</div>
<script>
    $(document).ready(function() {
        backurl.push("/artist/<?php echo $user; ?>");
    });
</script>