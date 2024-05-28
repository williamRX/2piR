import { Typography, TypographyProps, useMediaQuery, useTheme } from '@mui/material';

const Body: React.FC<TypographyProps> = (props) => {
  const theme = useTheme();
  const isLargeScreen = useMediaQuery(theme.breakpoints.up('sm'));
  const variant = isLargeScreen ? 'body1' : 'body2';

  return (
    <Typography 
      {...props} 
      variant={props.variant || variant} 
    />
  );
};

export default Body;