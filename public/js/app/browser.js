const setClientType =  () => {
    const w = window.innerWidth;
    if( w > 1280 ) {
        return  'desktop';
    } else if( w > 768 ) {
        return 'tablet';
    } else {
        return 'mobile';
    }
}





define({
    setClientType,
})