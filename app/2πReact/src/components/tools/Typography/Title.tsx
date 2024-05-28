import { Typography, TypographyProps, useMediaQuery, useTheme } from '@mui/material';

const Title: React.FC<TypographyProps> = (props) => {
  const theme = useTheme();
  const isLargeScreen = useMediaQuery(theme.breakpoints.up('md'));
  const variant = isLargeScreen ? 'h3' : 'h4';

  return (
    <Typography 
      {...props} 
      variant={props.variant || variant} 
    />
  );
};

export default Title;