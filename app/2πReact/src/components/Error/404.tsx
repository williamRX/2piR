
const NotFound = () => {

    return (
        <div style={{
            display: 'flex',
            flexDirection: 'column',
            justifyContent: 'center',
            alignItems: 'center',
            height: '100vh',
            backdropFilter: 'blur(5px)'
        }}>
            <h1>404</h1>
            <p>Page not found</p>
        </div>
    );
};

export default NotFound;